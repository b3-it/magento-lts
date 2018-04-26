<?php

class B3it_Subscription_Model_Order_Abstract extends Mage_Core_Model_Abstract
{
   
	/* @var $_SepaMandate Egovs_Paymentbase_Model_Sepa_Mandate */
	protected $_SepaMandate = null;
	protected $_customer = null;

    const SHIPPING_DEFAULT = 'freeshipping_freeshipping';
    protected $_shippingmethod = null;

	/**
	 * 
	 * 
	 * @param Mage_Sales_Model_Quote $quote
	 * @param B3it_Subscription_Model_Subscription $subscriptionitem
	 * @return Mage_Sales_Model_Quote_Item
	 */
	protected function addItem2Quote($quote,$subscriptionitem)
	{
		$product = Mage::getModel('catalog/product')->load($subscriptionitem->getProductId());
		$product->setData('website_id', 0);
		
		$buyRequest = new Varien_Object();
		$buyRequest->setData('qty',1);
		//$buyRequest->setData('period',$subscriptionitem->getPeriodId());

        $oldOptions = $this->_getLastOptions($subscriptionitem);
        $buyRequest->setOptions($oldOptions);

		$product->setSubscriptionItem($subscriptionitem);
		$item = $quote->addProduct($product, $buyRequest);


        $item->setSubscriptionItem($subscriptionitem);

        $item->save();
        if($quote->getIsVirtual()){
            //$quote->getBillingAddress()->addItem($item);
        }else{
            //$quote->getShippingAddress()->addItem($item);
        }


		return $item;
	}

    /**
     * @param B3it_Subscription_Model_Subscription $subscriptionitems
     * @return bool
     */
	protected function _isVirtual($subscriptionitems)
    {
        foreach($subscriptionitems as $item)
        {
            if(!$item->getCurrentOrderItem()->getIsVirtual()){
                return false;
            }
        }

        return true;
    }

	protected function _getLastOptions($subscriptionitem)
    {
        $oldOrderItem = $subscriptionitem->getCurrentOrderItem();
        $oldOptions = $oldOrderItem->getProductOptions();
        if(isset($oldOptions['info_buyRequest'])) {
            $oldBuyRequest = $oldOptions['info_buyRequest'];
            if(isset($oldBuyRequest['options'])) {
                return $oldBuyRequest['options'];
            }
        }

        return array();
    }
	
	protected function setRuleData($quote)
	{
		//$customer = Mage::getModel('customer/customer')->load($quote->getCustomerId());
		//Wird für Katalogpreisregeln benötigt
		//siehe: Mage_CatalogRule_Model_Observer::processAdminFinalPrice
		Mage::unregister('rule_data');
		Mage::register('rule_data', new Varien_Object(array(
		            'store_id'  => $quote->getStoreId(),
		            'website_id'  => $quote->getStore()->getWebsiteId(),
		            'customer_group_id' => $quote->getCustomerGroupId(),
		)));
	}

    protected function _getShippingMethod() {
        if ($this->_shippingmethod == null) {
            $this->_shippingmethod = Mage::getStoreConfig('b3it_subscription/general/shippingmethod');
            if (!is_string($this->_shippingmethod)) {
                $this->_shippingmethod = self::SHIPPING_DEFAULT;
            }
        }
        return $this->_shippingmethod;
    }

    protected function _setShippingMethod($quote)
    {
        $addresses = $quote->getAllShippingAddresses();
        foreach ($addresses as $address)
        {
            $address->setShippingMethod($this->_getShippingMethod());
            //wichtig damit die ShippingRates geladen werden
            $address->requestShippingRates();
            $address->save();
        }
        return $this;
    }

    protected function getQuote($item, $isVirtual)
    {
    	$customer = $this->_customer;
    	Mage::getSingleton('customer/session')->setCustomerGroupId($customer->getGroupId());
		$quote = Mage::getModel('sales/quote');
		
		$storeId = $customer->getStoreId();		
		if (empty($storeId) || '' == $storeId) {
			$storeId = 0;
		}				
		$quote->setStoreId($storeId);
		$quote->reserveOrderId();
		$quote->setIsVirtual($isVirtual);
		$quote->setCustomer($customer);
		
		$billingAdr = $customer->getDefaultBillingAddress();

		if(!$billingAdr){
		    Mage::throwException('DefaultBillingAddress not found! CustomerId: '.$customer->getId());
        }

        $billingAdr = Mage::getModel('sales/quote_address')->importCustomerAddress($billingAdr);
        $billingAdr->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING);
        $quote->setBillingAddress($this->addressToQuoteAddress($billingAdr));
        $billingAdr->setQuote($quote);

        if(!$isVirtual) {
            $shippingAdr = $customer->getDefaultShippingAddress();

            if (!$shippingAdr) {
                Mage::throwException('DefaultShippingAddress not found! CustomerId: '.$customer->getId());
            }

            $shippingAdr = Mage::getModel('sales/quote_address')->importCustomerAddress($shippingAdr);
            $shippingAdr->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING);
            $quote->setShippingAddress($this->addressToQuoteAddress($shippingAdr));
            $shippingAdr->setQuote($quote);
            $this->_setShippingMethod($quote);

        }


        
        $baseAdr = $customer->getBaseAddress();
        
        if (is_numeric($baseAdr) && $baseAdr > 0) {
        	$baseAdr = $customer->getAddressById($baseAdr);
        	if ($baseAdr && $baseAdr->getId()) {
        		 $baseAdr = Mage::getModel('sales/quote_address')->importCustomerAddress($baseAdr);
        		$baseAdr->setAddressType('base_address');
        		$quote->setBaseAddress($this->addressToQuoteAddress($baseAdr));
        		$baseAdr->setQuote($quote);
        	}
        }
       
        $quote->save();
        return $quote;
			
    }
    
    
    protected function getOrder($quote, $payment, $first_increment_id=null)
    {
    	/* @var $quote Mage_Sales_Model_Quote */

        $totals = $quote->getTotals();
       
       	if($totals['grand_total']['value'] < 0.01)
		{
			$this->addPaymentMethode($quote,'free');
		
		}
        else 
        {
        	$this->addPaymentMethode($quote,$payment->getCode());
        }

        $payment = $quote->getPayment();
        
        if( $lastSepa =  $payment->getLastSepaMethod())
        {
        	$ref =$lastSepa->getAdditionalInformation('mandate_reference');
        	if($ref != $this->_customer->getSepaMandateId()){
        		$this->fillSepaDebitValues($payment, $this->_customer);
        	}
        	else{
        		$this->copySepaDebitValues($payment->getLastSepaMethod(), $payment);
        	}
        }
        
        
        
        $quote->save();
        $quote->reserveOrderId();
        
		/* @var $service Mage_Sales_Model_Service_Quote */
        $service = Mage::getModel('sales/service_quote',$quote);
        try {
	        $service->submitAll();
	        $order = $service->getOrder();
	        
	        if($order)
	        {
	        	/** @var $orderItem Mage_Sales_Model_Order_Item **/
	        	foreach($order->getItemsCollection() as $orderItem)
	        	{

	        	}
	        	
	        	
		        if($first_increment_id){
		        	$order->setOriginalIncrementId($first_increment_id);
		        }
		        //$order->queueNewOrderEmail();
		        $order->save();
		        Mage::dispatchEvent('checkout_type_onepage_save_order_after',
		        		array('order'=>$order, 'quote'=>$quote));
	        }

        }
        catch (Exception $ex)
        {

        	$this->onFailure($order,$quote, $ex);
        }
        $quote->setIsActive(false)->save();
        
        //20111114::Frank Rochlitzer:: Die eCustomerID muss zurÃ¼ckgesetzt werden -> Caching Problem
        Mage::helper('paymentbase')->resetECustomerId();

        Mage::unregister('_singleton/salesrule/observer');

        

        return $order;
    }
    
    /**
     * Ein Item innerhalb einer Quote anhand seiner Id finden
     * @param Mage_Sales_Model_Quote $quote
     * @param int $id
     * @return Mage_Sales_Model_Quote_Item|NULL
     */
    protected function _findQuoteItem($quote,$id)
    {
    	/** @var $quote Mage_Sales_Model_Quote **/
    	foreach($quote->getAllItems() as $item){
    		if($item->getId() == $id){
    			return $item;
    		}
    	}
    	return null;
    }
    


    
    /**
     * Fehlerbehandlung
     * @param Mage_Sales_Model_Order $order
     * @param Mage_Sales_Model_Quote $quote
     * @return B3it_Subscription_Model_Order_Abstract
     */
    public function onFailure($order,$quote,$ex)
    {
        Mage::logException($ex);
    	
    	//nur für automatische Verlängerungen
    	if(!$quote->getIsBatchOrder()){
    		return $this;
    	}
    	if($order) {
            $order->setState(Mage_Sales_Model_Order::STATE_CANCELED, Mage_Sales_Model_Order::STATE_CANCELED, "Fehler bei der Subscriptionverlängerung", false);
            $order->save();
        }
    	$subscriptionIds = array();
    	foreach ($quote->getAllItems() as $quoteitem)
    	{
    	
    		$a = $quoteitem->getSubscriptionItem();
    		$subscriptionIds[] = $a->getId();
    	}
    	$msg = "Die Subscription(s) mit den Id(s) ". implode(',', $subscriptionIds)." konnte(n) nicht verlängert werden." ;
    	$msg .= " Die Bestellung " . $order->getIncrementId() ." wurde storniert.";
    	$msg .= " Meldung: " . $ex->getMessage();
    	$this->sendMailToAdmin($msg);
    }
    
    
    protected function addPaymentMethode($quote, $paymentMethod)
    {   	 
    	/* @var $quote Mage_Sales_Model_Quote */       
        $payment = $quote->getPayment();
        $payment->setMethod($paymentMethod);
        $quote->getShippingAddress()->setPaymentMethod($payment->getMethod());
    }
    
    
    protected  function addressToQuoteAddress(	$address)
    {
        $quoteAddress = Mage::getModel('sales/quote_address')
            ->setStoreId($address->getStoreId())
            ->setAddressType($address->getAddressType())
            ->setCustomerId($address->getCustomerId())
            ->setCustomerAddressId($address->getCustomerAddressId());

        Mage::helper('core')->copyFieldset('sales_convert_order_address', 'to_quote_address', $address, $quoteAddress);
        return $quoteAddress;
    }
    
    
 	
    
    protected function destroyOrder($order)
    {
    	//Egovs_Helper::printMemUsage('destroyOrder <=');
    	$this->unsetVar($order);
    	$this->unsetVar($order->getAddressesCollection());
    	$this->unsetVar($order->getAllItems());
    	//$this->unsetVar($order->getAllPayments());
    	$this->unsetVar($order->getRelatedObjects());
    	$this->unsetVar($order->getShipmentsCollection());
    	unset($order);
    	//Egovs_Helper::printMemUsage('destroyOrder =>');
    }
  
    
    
    
    protected function unsetVar($var)
    {
    	if(is_array($var))
    	{
    		foreach ($var as $k => $v) 
    		{
    			
    			$this->unsetVar($v);
    		}
    		unset($var);
    	}
    	else if((is_object($var)) && ($var instanceof Varien_Object))
    	{
    		$this->unsetVar($var->getData());
    		$var->unsetData();
    	}
    	else if((is_object($var)) && ($var instanceof Varien_Data_Collection))
    	{
    		//$var->CLEANUP();
    		unset($var);
    	}
    	else 
    	{
    		unset($var);
    	}
    }
    
    protected function copySepaDebitValues($oldPayment,$newPayment)
    {
    	
    	$newPayment->setCcNumberEnc($oldPayment->getCcNumberEnc());
    	$newPayment->setCcType($oldPayment->getCcType());
    	$newPayment->setCcOwner($oldPayment->getCcOwner());
    	
    	
    	
    	$vars = array('custom_accountholder_surname','custom_accountholder_name','custom_accountholder_street','custom_accountholder_housenumber',
    			'custom_accountholder_city','custom_accountholder_zip','custom_accountholder_land','mandate_reference');
    	$add = array();
    	$tmp =  $oldPayment->getAdditionalInformation();
    	foreach ($vars as $var)
    	{
    		$add[$var] = $oldPayment->getAdditionalInformation($var);
    		
    	}
    	$newPayment->setAdditionalInformation($add);
    	return $this;
    }
    
    protected function fillSepaDebitValues($newPayment, $customer)
    {
    	/* @var $mandate Egovs_Paymentbase_Model_Sepa_Mandate */
    	$mandate = $this->_SepaMandate; 
    	$ba = $mandate->getBankingAccount();
    	$newPayment->setCcNumber($ba->getIban());
    	$newPayment->setCcType($ba->getBic());
    	
    	$add = array();
    	$add['mandate_reference'] = $mandate->getReference();
    	
    	if($mandate->getAccountholderDiffers())
    	{
    		$newPayment->setCcOwner($mandate->getAccountholderFullname());
    		$add['custom_accountholder_surname'] = $mandate->getAccountholderSurname();
    		$add['custom_accountholder_name'] = $mandate->getAccountholderName();
    		$adr = $mandate->getAccountholderAddress();
    		$add['custom_accountholder_street'] = $adr->getStreet(false);
    		$add['custom_accountholder_housenumber'] = $adr->getHousenumber();
    		$add['custom_accountholder_city'] = $adr->getCity();
    		$add['custom_accountholder_zip'] = $adr->getZip();
    		$add['custom_accountholder_land'] = $adr->getCountry();
    		
    	}
    	else {
    		$helper =  Mage::helper('sepadebitbund');
    		$eCustomerId = $helper->getECustomerId($customer);
    		$helper->createCustomerForPayment($eCustomerId);  		
    		/* @var $eCustomer Egovs_Paymentbase_Model_Webservice_Types_Kunde */
    		$eCustomer = $helper->getECustomer();
    		
    		$add['custom_accountholder_surname'] = $eCustomer->nachname;
    		$add['custom_accountholder_name'] = $eCustomer->vorname;
    		$adr = $eCustomer->getRechnungsAdresse();
    		$add['custom_accountholder_street'] = $adr->getStreet(false);
    		$add['custom_accountholder_housenumber'] = $adr->getHousenumber();
    		$add['custom_accountholder_city'] = $adr->getCity();
    		$add['custom_accountholder_zip'] = $adr->getZip();
    		$add['custom_accountholder_land'] = $adr->getCountry();
    	}
    	
    	$newPayment->setAdditionalInformation($add);
    	return $this;
    	 
    	 
    	 
    	$vars = array('custom_accountholder_surname','custom_accountholder_name','custom_accountholder_street','custom_accountholder_housenumber',
    			'custom_accountholder_city','custom_accountholder_zip','custom_accountholder_land','mandate_reference');
    	$add = array();
    	$tmp =  $oldPayment->getAdditionalInformation();
    	foreach ($vars as $var)
    	{
    		$add[$var] = $oldPayment->getAdditionalInformation($var);
    
    	}
    	
    }
    
	public function sendMailToAdmin($body, $subject="Subscription Fehler:") {
		if (strlen($body) > 0) 
		{
			$mailTo =  Mage::helper('egovsbase')->getAdminMail("b3it_subscription/email/subscription_email_address");
			$mailTo = explode(';', $mailTo);
			/* @var $mail Mage_Core_Model_Email */
			$mail = Mage::getModel('core/email');
			$shopName = Mage::getStoreConfig('general/imprint/shop_name');
			$body = sprintf("Shop Name: %s\nWebsite: %s\n\n%s", $shopName, Mage::getBaseUrl(), $body);
			$mail->setBody($body);
					
			$mail->setToEmail($mailTo);

			
			$sender = array();
			$sender['name'] = Mage::getStoreConfig("b3it_subscription/email/subscription_email_sender");
			$sender['email'] = Mage::getStoreConfig("b3it_subscription/email/subscription_email_address");
			
			$sender['name'] = explode(';', $sender['name']);
			$sender['email'] = explode(';', $sender['email']);
			
			if(is_array($sender['name']))
			{
				$sender['name'] = $sender['name'][0];
			}
			
			if(is_array($sender['email']))
			{
				$sender['email'] = $sender['email'][0];
			}
			
			if(strlen($sender['name']) < 2){
				Mage::log('SubscriptionModul::Email Absendername ist in der Konfiguration nicht gesetzt.', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			}
			
			if(strlen($sender['email']) < 2){
				Mage::log('SubscriptionModul::Email Absendemail ist in der Konfiguration nicht gesetzt.', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			}
			
			$mail->setFromEmail($sender['email']);
			$mail->setFromName($sender['name']);
			
			$sdm = Mage::getStoreConfig('payment_services/paymentbase/webshopdesmandanten');
			$subject = sprintf("%s::%s", $sdm, $subject);
			$mail->setSubject($subject);
			try {
				$mail->send();
			}
			catch(Exception $ex) {
				$error = ('Unable to send email.');

				if (isset($ex)) {
					Mage::log($error.": {$ex->getTraceAsString()}", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				} else {
					Mage::log($error, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				}

				//TODO: Im Frontend sollte diese Meldung nicht zu sehen sein!
				//Mage::getSingleton('core/session')->addError($error);
			}
		}
	}
	
}