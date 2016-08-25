<?php
/**
 * Sid ExportOrder
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Model_Order
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Order extends Mage_Core_Model_Abstract
{
	protected $_vendor = null;
	protected $_contract = null;
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('exportorder/order');
    }
    
    
    
        
    public function getVendor() 
    {
      return $this->_vendor;
    }
    
    public function setVendor($value) 
    {
      $this->_vendor = $value;
      return $this;
    }
    
        
    public function getContract() 
    {
      return $this->_contract;
    }
    
    public function setContract($value) 
    {
      $this->_contract = $value;
      return $this;
    }
    
    public function processOrder($order)
    {
    	$storeId = $order->getStoreId();
    	try {
    	$format = $this->getVendor()->getExportFormatModel();
    	$content = $format->processOrder($order);
    	
    	$transfer = $this->getVendor()->getTransferModel();
    	$msg = $transfer->send($content,$order);
    	
    	$this->setMessage($msg)
    		->setUpdatedTime(now())
    		->setStatus(Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    		->save();
    	}
    	catch (Exception $ex)
    	{
    		$this->setMessage($ex->getMessage())
    		->setUpdatedTime(now())
    		->setStatus(Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_ERROR)
    		->save();
    		
    		$recipients = array();
    		$recipients[] = array('name' => Mage::getStoreConfig("framecontract/email/sender_name", $storeId),
    							  'email' => Mage::getStoreConfig("framecontract/email/sender_email_address", $storeId));
    		Mage::helper('exportorder')->sendEmail('exportorder/email/error',$recipients,array('message' => $ex->getMessage()),$storeId);
    	}
    	
    }
    
    
}
