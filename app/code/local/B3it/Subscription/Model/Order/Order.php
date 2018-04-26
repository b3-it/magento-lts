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
 
	protected $_deliverIds = array();
	protected $_perShippingAddress = false;
	
	
	/**
	 * Deliver id setzen
	 * @param B3it_Subscription_Model_Order_Order $deliverIds
	 * @return B3it_Subscription_Model_Order_Order
	 */
	public function setDeliverIds($deliverIds)
	{
		$this->_deliverIds = $deliverIds;
		return $this;
	}

	
	
	/**
	 * Bestellung für einen Liste von Subscription Items erstellen
	 * @param array B3it_Subscription_Model_Subscription $items
	 * @return B3it_Subscription_Model_Order_Order
	 */
	public function placeOrder( $items)
	{
        $isVirtual = $this->_isVirtual($items);
        //erstes Element
		$first = array_shift($items);
        //array shift rückgangig machen
        $items[] = $first;

        $this->_customer = Mage::getModel('customer/customer')->load($first->getCustomerId());

        $subscription_quote = $this->getQuote($first,$isVirtual);

		
		$oldOrder = Mage::getModel('sales/order')->load($first->getFirstOrderId());
		
		if($oldOrder){
			$first_increment_id = $oldOrder->getIncrementId();
		}
		unset($oldOrder);
		
		//add Items to Quote
		foreach ($items as $item)
		{
			$this->addItem2Quote($subscription_quote,$item);
		}
		
		$this->setRuleData($subscription_quote);
		$subscription_quote->collectTotals()->save();

        $totals = $subscription_quote->getTotals();

		$lastmethod = $this->getLastOrderPaymentMethod($first->getFirstOrderId());
				
		$subscription_quote->setIsBatchOrder(true);
		
		$AllowedPaymentMethod = $this->getAllowedPaymentMethod($subscription_quote, $lastmethod);
		if($AllowedPaymentMethod)
		{
			//falls die letzte Bezahlmethode nicht mehr zur Verfügung steht
			//$AllowedPaymentMethod =  array_shift($AllowedPaymentMethods);
			
			if(($AllowedPaymentMethod->getCode() == 'sepadebitbund') && ($lastmethod->getMethod() == 'sepadebitbund'))
			{
				$AllowedPaymentMethod->setLastSepaMethod($lastmethod);
			}
			
			if(!$AllowedPaymentMethod)
			{
				Mage::log("Erlaubte Zahlmethode für Subscriptionverlängerung nicht gefunden!", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				return $this;
			}
			
			try {
				$order = $this->getOrder($subscription_quote, $AllowedPaymentMethod, $first_increment_id);
                foreach($items as $item)
                {
                    $item->setRenewalStatus(B3it_Subscription_Model_Renewalstatus::STATUS_REORDERD);
                    $item->getResource()->saveField($item,'renewal_status');
                }
			}
			catch(Exception $ex)
			{
				Mage::log($ex->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			}
		}
		else 
		{

			$this->sendSubscriptionRefreshEMail($subscription_quote->getCustomer(), $items);

		}
		return $this;
	}
	
	/**
	 * Ermitteln der gültigen Zahlmethode, die zuletzt benutzte hat Vorrang
	 * debit ist nur erlaubt wenn die initiale Methode debit war
	 * @param Mage_Sales_Model_Quote $subscription_quote
	 * @param Mage_Payment_Model_Method_Abstract $lastmethod
	 * @return Mage_Payment_Model_Method_Abstract|NULL
	 */
	protected function getAllowedPaymentMethod($subscription_quote, $lastmethod)
	{
			$allowed = Mage::getConfig()->getNode('global/subscription/allowed_renewal_payment_methods')->asArray();
			$store = $subscription_quote ? $subscription_quote->getStoreId() : null;
            $methods = Mage::helper('payment')->getStoreMethods($store, $subscription_quote);
            $total = $subscription_quote->getBaseSubtotal();
            $result = array();
            foreach ($methods as $key => $method) {
                if ($this->_canUseMethod($method, $subscription_quote,$allowed, $lastmethod)){
               		
               		if ($method->getCode() == $lastmethod->getMethod())
               		{
               			return $method;
               		}
               		if ($method->getCode() != 'sepadebitbund')
               		{
               			$result[] = $method;
               		}
                }
            }
            
            //umsortieren: der erste Wert aus $allowed soll zurückgeliefert werden
            if(count($result) > 0){
            	foreach($allowed as $a)
            	{
            		foreach ($result as $method) 
            		{
            			if($method->getCode() == $a){
            				return $method;
            			}
            		}
            	}
            }
            
            return null;
	}
	
	/**
	 * ermitteln ob die Zahlmethode zu verfügung steht, berücksichtigen und priorisieren der ersten Zahlmethode
	 * @param Mage_Payment_Model_Method_Abstract $method
	 * @param Mage_Sales_Model_Quote $subscription_quote
	 * @param Mage_Payment_Model_Method_Abstract $allowed
	 * @param Mage_Payment_Model_Method_Abstract $lastmethod
	 * @return boolean
	 */
	protected function _canUseMethod($method,$subscription_quote, $allowed, $lastmethod)
	{
		if(!in_array($method->getCode(), $allowed)){
			return false;
		}
		
		if (!$method->canUseForCountry($subscription_quote->getBillingAddress()->getCountry())) {
			return false;
		}
	
		if (!$method->canUseForCurrency(Mage::app()->getStore()->getBaseCurrencyCode())) {
			return false;
		}
	
		
		if(($lastmethod->getMethod() == "sepadebitbund") && ($method->getCode() == "sepadebitbund" )) {
			//$ref = $lastmethod->getAdditionalInformation('mandate_reference');
			$customer = $subscription_quote->getCustomer();
			if(!$customer->getSepaMandateId()){
				return false;
			}else
			{
				$this->_SepaMandate = Mage::getModel('sepadebitbund/sepadebitbund')->getMandate($customer->getSepaMandateId());
				if(!$this->_SepaMandate)
				{
					return false;
				}
				if(!$this->_SepaMandate->isActive())
				{
					return false;
				}
				if(!$this->_SepaMandate->isMultiPayment())
				{
					return false;
				}
			}			
			
		}
		
		/**
		 * Checking for min/max order total for assigned payment method
		 */
		$total = $subscription_quote->getBaseGrandTotal();
		$minTotal = Mage::app()->getLocale()->getNumber($method->getConfigData('min_order_total'));
		$maxTotal = Mage::app()->getLocale()->getNumber($method->getConfigData('max_order_total'));
	
		if((!empty($minTotal) && ($total < $minTotal)) || (!empty($maxTotal) && ($total > $maxTotal))) {
			return false;
		}
		return true;
	}
	
	/**
	 * Zahlmethode setzen
	 * @param Mage_Payment_Model_Method_Abstract $method
	 * @param Mage_Sales_Model_Quote $subscription_quote
	 * @return B3it_Subscription_Model_Order_Order
	 */
	protected function _assignMethod($method, $subscription_quote)
	{
		$method->setInfoInstance($subscription_quote->getPayment());
		return $this;
	}
	
	/**
	 * Email an Kunden zur Erneuerung des Subscriptions senden
	 * @param Mage_Customer_Model_Customer $customer
	 * @param B3it_Subscription_Model_Order_Order $subscriptionitems
	 */
	protected function sendSubscriptionRefreshEMail($customer, $subscriptionitems)
	{
		foreach ($subscriptionitems as $subscriptionitem){
			$data=array();
			$orderitem = Mage::getModel('sales/order_item')->load($subscriptionitem->getCurrentOrderitemId());
			$data['item'] = $subscriptionitem;
			$data['order'] = Mage::getModel('sales/order')->load($subscriptionitem->getFirstOrderId());
			$data['product'] = Mage::getModel('catalog/product')->load($orderitem->getProductId());
			$data['station'] = Mage::getModel('stationen/stationen')->load($orderitem->getStationId());
			Mage::helper('b3it_subscription')->sendEmail($customer->getEmail(), $customer, $data, 'b3it_subscription/email/renewal_subscription_template');
			$subscriptionitem->setRenewalStatus(B3it_Subscription_Model_Renewalstatus::STATUS_EMAIL_SEND);
			$subscriptionitem->setStatus(B3it_Subscription_Model_Status::STATUS_EXPIRED);
			$subscriptionitem->save();
		}
	}
	
	/**
	 * letzte Zahlmethode ermitteln
	 * @param integer $lastOrderId
	 * @return <Mage_Core_Model_Abstract, Mage_Core_Model_Abstract>|string
	 */
	protected function getLastOrderPaymentMethod($lastOrderId)
	{
		$payment = Mage::getModel('sales/order_payment')->load($lastOrderId,'parent_id');
		if($payment->getId()){
			return $payment;
		}
		return '';
	}
	
}