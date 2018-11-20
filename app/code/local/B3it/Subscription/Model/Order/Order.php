<?php
/**
 * B3it Subscription
 *
 *
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Model_Order_Order
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 - IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Model_Order_Order extends B3it_Subscription_Model_Order_Abstract
{
 
	protected $_initialOrder = null;
	protected $_initialOrderId = null;

	
	
	/**
	 * Bestellung für einen Liste von Subscription Items erstellen
	 * @param array B3it_Subscription_Model_Subscription $items
	 * @return B3it_Subscription_Model_Order_Order
	 */
	public function placeOrder()
	{
		$items = $this->_items;
        $isVirtual = $this->_isVirtual();
        //erstes Element
		$first = reset($items);      
        $this->_customer = Mage::getModel('customer/customer')->load($first->getCustomerId());

        
        
        $first_increment_id = "";
        if($oldOrder = $this->_getInitialOrder()){
        	$first_increment_id = $oldOrder->getIncrementId();
        	$this->_shippingMethod = $oldOrder->getShippingMethod();
        }
       
                
        $quote = $this->_getQuote($isVirtual);
       
        $quote->setIsBatchOrder(true);
		
		
		try {
			//add Items to Quote
			foreach ($items as $item)
			{
				$this->_addItem2Quote($quote,$item);
			}
			
			$this->_setQuoteAddresses($quote);
			$this->setRuleData($quote);
			if(!$isVirtual){
				$quote->getShippingAddress()->setCollectShippingRates(true);
				
				$shippingMethod = $this->_getShippingMethod();
				if(!$shippingMethod){
					Mage::throwException("shippingMethod not found: ".$shippingMethod);
				}
				$this->_setShippingMethod($quote,$shippingMethod);
			}
			$quote->collectTotals()->save();
			
			
			$this->_paymentMethod = $this->_getPaymentMethode($quote,$this->_getInitialOrderId());
			if(!$this->_paymentMethod)
			{
				Mage::throwException("paymentMethod not found: ".$this->_getLastOrderPaymentMethod($this->_getInitialOrderId()));
			}
			
		
			
			$order = $this->_getOrder($quote, $first_increment_id);
            
	            foreach($items as $item)
	            {
	            	$item->saveRenewalStatus(B3it_Subscription_Model_Renewalstatus::STATUS_REORDERD);
	            }
	            //$this->sendSubscriptionRefreshEMail($items);
			}
			catch(Exception $ex)
			{
				Mage::log($ex->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				foreach($items as $item)
				{
					$item->saveRenewalStatus(B3it_Subscription_Model_Renewalstatus::STATUS_ERROR);
				}
			}
		
		
		return $this;
	}
	

	
	protected function _getInitialOrderId()
	{
		if($this->_initialOrderId == null)
		{
			$first = reset($this->_items);
			$this->_initialOrderId = $first->getFirstOrderId();
		}
		return $this->_initialOrderId;		
	}
	
	protected function _getInitialOrder()
	{
		if($this->_initialOrder == null)
		{
			$this->_initialOrder = Mage::getModel('sales/order')->load($this->_getInitialOrderId());
		}
		return $this->_initialOrder; 
	}
	
	
	
	/**
	 * Email an Kunden zur Erneuerung des Subscriptions senden
	 * @param Mage_Customer_Model_Customer $customer
	 * @param B3it_Subscription_Model_Order_Order $subscriptionitems
	 */
	protected function sendSubscriptionRefreshEMail($subscriptionitems)
	{
		$customer = $this->_customer;
		foreach ($subscriptionitems as $subscriptionitem){
			$data=array();
			$orderitem = Mage::getModel('sales/order_item')->load($subscriptionitem->getCurrentOrderitemId());
			$data['item'] = $subscriptionitem;
			//ggf neuladen überARBEITEN
			$data['order'] = Mage::getModel('sales/order')->load($subscriptionitem->getFirstOrderId());
			$data['product'] = Mage::getModel('catalog/product')->load($orderitem->getProductId());
			Mage::helper('b3it_subscription')->sendEmail($customer->getEmail(), $customer, $data, 'b3it_subscription/email/renewal_subscription_template');
			$subscriptionitem->setRenewalStatus(B3it_Subscription_Model_Renewalstatus::STATUS_EMAIL_SEND);
			$subscriptionitem->setStatus(B3it_Subscription_Model_Status::STATUS_EXPIRED);
			$subscriptionitem->save();
		}
	}
	
	
	function __destruct() {
		if($this->_initialOrder != null){
			unset($this->_initialOrder);
		}
		if($this->_customer != null){
			unset($this->_customer);
		}
	}
}