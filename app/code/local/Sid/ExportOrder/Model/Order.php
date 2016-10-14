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

/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method int getOrderId()
 *  @method setOrderId(int $value)
 *  @method string getTransfer()
 *  @method setTransfer(string $value)
 *  @method string getFormat()
 *  @method setFormat(string $value)
 *  @method string getMessage()
 *  @method setMessage(string $value)
 *  @method int getStatus()
 *  @method setStatus(int $value)
 *  @method  getCreatedTime()
 *  @method setCreatedTime( $value)
 *  @method  getUpdateTime()
 *  @method setUpdateTime( $value)
 *  @method int getContractId()
 *  @method setContractId(int $value)
 *  @method int getVendorId()
 *  @method setVendorId(int $value)
 *  @method int getSemaphor()
 *  @method setSemaphor(int $value)
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
    
    
    
    /**
     * @return Sid_Framecontract_Model_Vendor
     */    
    public function getVendor() 
    {
    	if($this->_vendor == null)
    	{
    		$this->_vendor = Mage::getModel('framecontract/vendor')->load($this->getVendorId());
    	}
      	return $this->_vendor;
    }
    
    public function setVendor($value) 
    {
      $this->_vendor = $value;
      return $this;
    }
    
        
    public function getContract() 
    {
    	if($this->_contract = null)
    	{
    		$this->_contract =  Mage::getModel('framecontract/contract')->load($this->getContractId());
    	}
      	return $this->_contract;
    }
    
    public function setContract($value) 
    {
      $this->_contract = $value;
      return $this;
    }
    
    /**
     * 
     * @param Mage_Sales_Model_Order $order
     * @return Sid_ExportOrder_Model_Order
     */
    public function processOrder(Mage_Sales_Model_Order $order)
    {
    	$storeId = $order->getStoreId();
    	try {
	    	$format = $this->getVendor()->getExportFormatModel();
	    	$transfer = $this->getVendor()->getTransferModel();
	    	
	    	
	    	$this->setLog(sprintf("process Order: %s, Format: %s, Transfer: %s", $order->getId(), $this->getVendor()->getExportFormat(),$this->getVendor()->getTransferType()));
	    	
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
    	$allOrderIds = array();
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
    				$this->setLog(sprintf("send pendingOrders: %s", implode(',',$orderIds)));
    			}
    			$content = array();
    			$orderIds = array();
    		}
    		
    		if(!$skip){
	    		$content[$order->getIncrementId()] = $format->processOrder($order);
	    		$orderIds[] = $order->getId();
    		}
    		
    		$allOrderIds[] = $order->getId();
    	}
    	
    	
    	
    	if(count($content) > 0){
    		$transfer->sendOrders($content, $format, $orderIds, $vendor);
    		$this->setLog(sprintf("send pendingOrders: %s", implode(',',$orderIds)));
    	}
    	
    	if(count($allOrderIds) > 0)
    	{
    		$this->setLog(sprintf("process pendingOrders: %s", implode(',',$allOrderIds)));
    	}
    	 
    }
    
    
}
