<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_Participant
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_Participant extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventmanager/participant');
    }
    
    
    
    protected function _afterSave()
    {
    	$this->_saveAttribute('industry',Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY);
    	$this->_saveAttribute('lobby',Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY);
    	
    	return parent::_afterSave();
    }
    
    protected function _afterLoad()
    {
    	$this->getResource()->loadAttribute($this, 'industry',Bfr_EventManager_Model_Lookup_Typ::TYPE_INDUSTRY);
    	$this->getResource()->loadAttribute($this, 'lobby',Bfr_EventManager_Model_Lookup_Typ::TYPE_LOBBY);
    	
    	return parent::_afterLoad();
    }
    
    protected function _saveAttribute($field, $key)
    {
    	$orig = $this->getResource()->getAttributeValues($this->getId(), $key);
    	$data =  $this->getData($field);
    	
    	if(!is_array($orig)){
    		$orig = array();
    	}
    	
    	if(!is_array($data)){
    		$data = array();
    	}
    	
    	$delete= array_diff($orig,$data);
    	$insert= array_diff($data,$orig);
    	
    	$this->getResource()->deleteAttribute($this->getId(), $delete);
    	$this->getResource()->saveAttribute($this->getId(),$insert);
    	
    	return $this;
    	
    }
    
    
    public function importOrder($order,$orderItem)
    {
    	$customer = $order->getCustomer();
    	$customer = Mage::getModel('customer/customer')->load($customer->getId());
    	//$address = Mage::getModel('customer/address')->load($order->getBillingAddress()->getId());
    	$address = $order->getBillingAddress();
    	$productOptions = ($orderItem->getProductOptions());
    	$personalOptions = $productOptions['info_buyRequest']['personal_options'];
    	if(!is_array($personalOptions)){
    		$personalOptions = array();
    	}
    	$productId = $orderItem->getProduct()->getId();
    	$event = Mage::getModel('eventmanager/event')->load($productId,'product_id');
    	if(!$event->getId()){
    		return $this;
    	}
    	$collection = Mage::getModel('eventbundle/personal_option')->getCollection(); 
    	$collection->getSelect()
    		->where('product_id='.intval($productId));
    	
    	$mapping = array();
    	foreach($collection->getItems() as $option)
    	{
    		if(isset($personalOptions[$option->getId()]) && (strlen(trim($personalOptions[$option->getId()])) > 0))
    		{
    			$mapping[$option->getName()] = $personalOptions[$option->getId()];
    		}else {
    			$mapping[$option->getName()] = $customer->getData($option->getName());
    		}
    	}
    	
    	
    	
    	$this->setOrderId($order->getId());
    	$this->setOrderItemId($orderItem->getId());
    	$this->setEventId($event->getId());
    	$this->setCreatedTime(now())->setUpdateTime(now());
    	$fields = array('prefix','firstname','lastname','company','company2','company3','street','city','postcode','email');
    	foreach($fields as $field){
    		if(isset($mapping[$field])){
    			$this->setData($field,$mapping[$field]);
    		}elseif ($customer->getData($field) != null) {
    			$this->setData($field,$customer->getData($field));
    		}else{
    			$this->setData($field,$address->getData($field));
    		}
    	}
    	
    	
    	$this->save();
    	
    	
    	//$t = 2/0;
    	
    	
    }
}
