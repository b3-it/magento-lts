<?php
/**
 * Dwd Abo
 *
 *
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Model_Order_Order
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2014 B3 - IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Model_Order_Order extends Dwd_Abo_Model_Order_Abstract
{
 
	protected $_deliverIds = array();
	protected $_perShippingAddress = false;
	
	
	/**
	 * Deliver id setzen
	 * @param Dwd_Abo_Model_Order_Order $deliverIds
	 * @return Dwd_Abo_Model_Order_Order
	 */
	public function setDeliverIds($deliverIds)
	{
		$this->_deliverIds = $deliverIds;
		return $this;
	}

	
	
	/**
	 * Bestellung für einen Liste von Abo Items erstellen
	 * @param array $items
	 * @return Dwd_Abo_Model_Order_Order
	 */
	public function createOrders($items)
	{

		$first = array_shift($items);
		$abo_quote = $this->getQuote($first);
		$this->addItem($abo_quote,$first);
		
		$oldOrder = Mage::getModel('sales/order')->load($first->getFirstOrderId());
		
		if($oldOrder){
			$first_increment_id = $oldOrder->getIncrementId();
		}
		unset($oldOrder);
		
		//add Items to Quote
		foreach ($items as $item)
		{
			$this->addItem($abo_quote,$item);
		}
		
		$this->setRuleData($abo_quote);
		$abo_quote->collectTotals()->save();
		
		
		$lastmethod = $this->getLastOrderPaymentMethod($first->getFirstOrderId());
				
		$abo_quote->setIsBatchOrder(true);
		
		$AllowedPaymentMethod = $this->getAllowedPaymentMethod($abo_quote, $lastmethod);
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
				Mage::log("Erlaubte Zahlmethode für Aboverlängerung nicht gefunden!", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				return $this;
			}
			
			try {
				$order = $this->getOrder($abo_quote, $AllowedPaymentMethod, $first_increment_id);
			}
			catch(Exception $ex)
			{
				Mage::log($ex->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			}
		}
		else 
		{
			//array shift rückgangig machen
			$items[] = $first;
			$this->sendAboRefreshEMail($abo_quote->getCustomer(), $items);
		}
		return $this;
	}
	
	/**
	 * Ermitteln der gültigen Zahlmethode, die zuletzt benutzte hat Vorrang
	 * debit ist nur erlaubt wenn die initiale Methode debit war
	 * @param Mage_Sales_Model_Quote $abo_quote
	 * @param Mage_Payment_Model_Method_Abstract $lastmethod
	 * @return Mage_Payment_Model_Method_Abstract|NULL
	 */
	protected function getAllowedPaymentMethod($abo_quote, $lastmethod)
	{
			$allowed = Mage::getConfig()->getNode('global/allowed_renewal_payment_methods')->asArray();
			$store = $abo_quote ? $abo_quote->getStoreId() : null;
            $methods = Mage::helper('payment')->getStoreMethods($store, $abo_quote);
            $total = $abo_quote->getBaseSubtotal();
            $result = array();
            foreach ($methods as $key => $method) {
                if ($this->_canUseMethod($method, $abo_quote,$allowed, $lastmethod)){
               		
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
	 * @param Mage_Sales_Model_Quote $abo_quote
	 * @param Mage_Payment_Model_Method_Abstract $allowed
	 * @param Mage_Payment_Model_Method_Abstract $lastmethod
	 * @return boolean
	 */
	protected function _canUseMethod($method,$abo_quote, $allowed, $lastmethod)
	{
		if(!in_array($method->getCode(), $allowed)){
			return false;
		}
		
		if (!$method->canUseForCountry($abo_quote->getBillingAddress()->getCountry())) {
			return false;
		}
	
		if (!$method->canUseForCurrency(Mage::app()->getStore()->getBaseCurrencyCode())) {
			return false;
		}
	
		
		if(($lastmethod->getMethod() == "sepadebitbund") && ($method->getCode() == "sepadebitbund" )) {
			//$ref = $lastmethod->getAdditionalInformation('mandate_reference');
			$customer = $abo_quote->getCustomer();
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
		$total = $abo_quote->getBaseGrandTotal();
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
	 * @param Mage_Sales_Model_Quote $abo_quote
	 * @return Dwd_Abo_Model_Order_Order
	 */
	protected function _assignMethod($method, $abo_quote)
	{
		$method->setInfoInstance($abo_quote->getPayment());
		return $this;
	}
	
	/**
	 * Email an Kunden zur Erneuerung des Abos senden
	 * @param Mage_Customer_Model_Customer $customer
	 * @param Dwd_Abo_Model_Order_Order $aboitems
	 */
	protected function sendAboRefreshEMail($customer, $aboitems)
	{
		foreach ($aboitems as $aboitem){
			$data=array();
			$orderitem = Mage::getModel('sales/order_item')->load($aboitem->getCurrentOrderitemId());
			$data['item'] = $aboitem;
			$data['order'] = Mage::getModel('sales/order')->load($aboitem->getFirstOrderId());
			$data['product'] = Mage::getModel('catalog/product')->load($orderitem->getProductId());
			$data['station'] = Mage::getModel('stationen/stationen')->load($orderitem->getStationId());
			Mage::helper('dwd_abo')->sendEmail($customer->getEmail(), $customer, $data, 'dwd_abo/email/renewal_abo_template');
			$aboitem->setRenewalStatus(Dwd_Abo_Model_Renewalstatus::STATUS_EMAIL_SEND);
			$aboitem->setStatus(Dwd_Abo_Model_Status::STATUS_EXPIRED);
			$aboitem->save();
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