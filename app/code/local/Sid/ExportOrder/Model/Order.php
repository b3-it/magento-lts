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
    	$transfer = $this->getVendor()->getTransferModel();
    	
    	if(!$transfer->canSend()){
    		return $this;
    	}
    	
    	$content = $format->processOrder($order);
    	
    	$msg = $transfer->send($content,$order);
    	
    	$this->setMessage($msg)
    		->setUpdateTime(now())
    		->setStatus(Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_SUCCESS)
    		->save();
    	
    		if(strlen($msg) > 0){
    			Mage::throwException($msg);
    		}
    	}
    	catch (Exception $ex)
    	{
    		$this->setMessage($ex->getMessage())
    		->setUpdateTime(now())
    		->setStatus(Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_ERROR)
    		->save();
    		
    		$recipients = array();
    		$recipients[] = array('name' => Mage::getStoreConfig("framecontract/email/sender_name", $storeId),
    							  'email' => Mage::getStoreConfig("framecontract/email/sender_email_address", $storeId));
    		Mage::helper('exportorder')->sendEmail('exportorder/email/error',$recipients,array('message' => $ex->getMessage()),$storeId);
    	}
    	
    }
    
    public function processPendingOrders($transfer = 'link')
    {
    	$collection = Mage::getResourceModel('sales/order_collection');
    	$collection->getSelect()
    	->join(array('export'=>$collection->getTable('exportorder/order')),'main_table.entity_id = export.order_id',array('vendor_id'))
    	->where('export.status = ' .Sid_ExportOrder_Model_Syncstatus::SYNCSTATUS_PENDING)
    	->where("export.transfer =?", $transfer)
    	->order('vendor_id');
    	
    	$vendorId = 0;
    	$content = array();
    	$orderIds = array();
    	$skip = false;
    	foreach($collection as $order)
    	{
    		if($vendorId != $order->getVendorId()){
    			$vendorId = $order->getVendorId();
    			$vendor = Mage::getModel('framecontract/vendor')->load($vendorId);
    			$format = $vendor->getExportFormatModel();
    			$transfer = $vendor->getTransferModel();
    			$expr = $transfer->getCron();
    			if(!empty($expr)){
    				$skip = !Mage::helper('exportorder')->canSchedule($expr);
    			}
    			if(count($content) > 0){
    				
    				$transfer->sendOrders($content, $format, $orderIds, $vendor);
    			}
    			$content = array();
    			$orderIds = array();
    		}
    		
    		if(!$skip){
	    		$content[$order->getIncrementId()] = $format->processOrder($order);
	    		$orderIds[] = $order->getId();
    		}
    	}
    	
    	if(count($content) > 0){
    		$transfer->sendOrders($content, $format, $orderIds, $vendor);
    	}
    	
    	
    	 
    }
    
    
}
