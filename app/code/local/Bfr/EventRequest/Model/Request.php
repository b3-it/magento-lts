<?php
/**
 * Bfr EventRequest
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Model_Request
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Model_Request extends Mage_Core_Model_Abstract
{
	
	private $_customer = null;
	private $_address = null;
	private $_product = null;
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventrequest/request');
    }
    
    
    public function registerQuote($quote, $customer)
    {
    	$errors = array();
    	$items = $quote->getAllItems();
    	$n = 0;
    	foreach($items as $item)
    	{
    		if($item->getParentItem() === null ){
    			$n++;
    		}
    	}
    	
    	if($n != 1){
    		$errors[] = Mage::helper('eventrequest')->__("You can register one event only!");
    		return $errors;
    	}
    	
    	
    	
    	$item = $items[0];
    	if(!$item->getProduct()->getEventrequest()){
    		$errors[] = Mage::helper('eventrequest')->__("You can register events only!");
    		return $errors;
    	}
    	
    	
    	$request = Mage::getModel('eventrequest/request')->loadByCustomerAndProduct($customer->getId(), $item->getProduct()->getId());
    	if($request->getId()){
    		$errors[] = Mage::helper('eventrequest')->__('An application of %s has been found!',$item->getProduct()->getName());
    		return $errors;
    	}
    	
    	//todo überprüfen ob user bereits registriert
    	
    	$this->setQuoteId($quote->getId());
    	
    	$this->setProductId($item->getProduct()->getId());
    	$this->setTitle($item->getProduct()->getName());
    	$this->setStatus(Bfr_EventRequest_Model_Status::STATUS_REQUESTED);
    	$this->setCustomerId($customer->getId());
    	$this->setCreatedTime(now());
    	$this->setUpdateTime(now());
    
    	$this->setLog("Register Product ". $item->getProduct()->getId() . " for User " .$customer->getId());
    	
    	$this->save();
    	$quote->setIsActive(false)->setIsEventRequest(1)->save();
    
    }
    
    public function getCustomer()
    {
    	if($this->_customer == null){
    		$this->_customer = Mage::getModel('customer/customer')->load($this->getCustomerId());
    	}
    	return $this->_customer;
    }
    
    public function getProduct()
    {
    	if($this->_product == null){
    		$this->_product = Mage::getModel('catalog/product')->load($this->getProductId());
    	}
    	return $this->_product;
    }
    
    public function getAddress()
    {
    	if($this->_address == null){
    		$this->_address = Mage::getModel('customer/address')->load($this->getCustomer()->getDefaultBilling());
    	}
    	return $this->_address;
    }
    
    public function getCustomerName()
    {
    	return trim($this->getAddress()->getCompany(). " ". $this->getCustomer()->getFirstname(). " ". $this->getCustomer()->getLastname());
    }
    
    public function getProductName()
    {
    	return trim($this->getProduct()->getName());
    }
    
    
    
    
    private function sendAcceptedEmail()
    {
    	$data=array();
    	$data['customer'] = $this->getCustomer();
    	$data['product'] = $this->getProduct();
    	$data['created_time'] = $this->getCreatedTime();
    	$this->setLog(sprintf("Sende Email über Zulassung an %s für Produkt %s",$this->getCustomer()->getId(),$this->getProduct()->getId()));
    	Mage::helper('eventrequest')->sendEmail($this->getCustomer()->getEmail(), $this->getCustomer(), $data, 'event_request/email/eventrequest_accept_template');
    }
    
    private function sendDeniedEmail()
    {
    	$data=array();
    	$data['customer'] = $this->getCustomer();
    	$data['product'] = $this->getProduct();
    	$data['created_time'] = $this->getCreatedTime();
    	$this->setLog(sprintf("Sende Email über Ablehnung an %s für Produkt %s",$this->getCustomer()->getId(),$this->getProduct()->getId()));
    	Mage::helper('eventrequest')->sendEmail($this->getCustomer()->getEmail(), $this->getCustomer(), $data, 'event_request/email/eventrequest_reject_template');
    }
    
    
    /**
     * der pausierte Warenkorb wird wieder aktiviert
     * @return Bfr_EventRequest_Model_Request
     */
    private function reactivateQuote()
    {
    	$id = $this->getQuoteId();
    	$quote = Mage::getModel('sales/quote')->loadByIdWithoutStore($this->getQuoteId());
    	//$new = Mage::getModel('sales/quote')->loadByCustomer($this->getCustomer());
    	//if($new->getId()){
    	//	$new->merge($old);
    	//	return $this;
    	//}
 		if (Mage::getSingleton('customer/session')->getCustomerId()) 
    		{
	    		$customerQuote = Mage::getModel('sales/quote')
	    		->setStoreId(Mage::app()->getStore()->getId())
	    		->loadByCustomer(Mage::getSingleton('customer/session')->getCustomerId());
	    	
	    		if ($customerQuote->getId() && $quote->getId() != $customerQuote->getId()) {
	    				$customerQuote->merge($quote)
	    				->collectTotals()
	    				->save();
	    	
	    			$this->setQuoteId($customerQuote->getId());
	    	
	    			if ($quote->getId()) {
	    				$quote->delete();
	    			}
	    			$this->setQuoteId($customerQuote->getId())
	    				->save();
	    		}else {
	    			$quote->setIsActive(true)->save();
	    		}
    		}else {
	    			$quote->setIsActive(true)->save();
	    	}
    
    	
    	
    	
    	
    	
    }



    protected function _afterDelete() {
        if($this->getQuoteId()){
            $order = Mage::getModel('sales/order')->load($this->getQuoteId(),'quote_id');
            if(!$order->getId()) {
                $quote = Mage::getModel('sales/quote');
                $quote->load($this->getQuoteId());
                $quote->delete();
            }
        }
        return parent::_afterDelete(); // TODO: Change the autogenerated stub
    }

    /**
     * Falls die Anmeldung bestätigt wurde wird das 
     * Produkt in den Warenkorb gelegt und der Kunde informiert
     * @see Mage_Core_Model_Abstract::_afterSave()
     */
    protected function _afterSave()
    {
    	parent::_afterSave();
    	if(($this->getData('status') == Bfr_EventRequest_Model_Status::STATUS_ACCEPTED ) && ($this->getData('status') != $this->getOrigData('status'))){
    		$this->reactivateQuote();
    		$this->sendAcceptedEmail();
    	}
    	else if(($this->getData('status') == Bfr_EventRequest_Model_Status::STATUS_REJECTED ) && ($this->getData('status') != $this->getOrigData('status'))){
    		$this->sendDeniedEmail();
    	}
    	
    	return $this;
    }
    
    public function isAccepted()
    {
    	return $this->getStatus() == Bfr_EventRequest_Model_Status::STATUS_ACCEPTED;
    }
    
    /**
     * Laden mit Benutzer und Produkt
     * @param int $customerId
     * @param int $productId
     * @return Bfr_EventRequest_Model_Request
     */
    public function loadByCustomerAndProduct($customerId, $productId)
    {
    	$this->getResource()->loadByCustomerAndProduct($this, $customerId, $productId);
    	
    	return $this;
    }
}
