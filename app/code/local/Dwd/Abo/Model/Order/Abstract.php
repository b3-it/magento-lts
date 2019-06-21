<?php

class Dwd_Abo_Model_Order_Abstract extends Mage_Core_Model_Abstract
{
   
	/* @var $_SepaMandate Egovs_Paymentbase_Model_Sepa_Mandate */
	protected $_SepaMandate = null;
	protected $_customer = null;
	
	/**
	 * 
	 * 
	 * @param Mage_Sales_Model_Quote $quote
	 * @param Dwd_Abo_Model_Abo $aboitem
	 * @return Mage_Sales_Model_Quote_Item
	 */
	protected function addItem($quote,$aboitem)
	{
		$product = Mage::getModel('catalog/product')->load($aboitem->getProductId());
		$product->setData('website_id', 0);

		$station_id = $aboitem->getStationId();
		if($aboitem->hasData('icd_station_id')){
            $station_id = $aboitem->getData('icd_station_id');
        }

		$buyRequest = new Varien_Object();
		$buyRequest->setData('periode',$aboitem->getPeriodId());
		$buyRequest->setData('station',$station_id);
		
		$product->setAboItem($aboitem);
		$item = $quote->addProduct($product, $buyRequest);
		$item->setQty(1);
		

       
        /* @var $item Mage_Sales_Model_Quote_Item */
        $item->addOption(array('code'=>'periode_id','value'=>$aboitem->getPeriodId()));
        $item->addOption(array('code'=>'station_id','value'=>$station_id));
        $item->addOption(array('code'=>'previous_periode_end','value'=>$aboitem->getStopDate()));
      
       
        $p = Mage::getModel('periode/periode')->load($aboitem->getPeriodId());
        $item->setPeriode($p);
        $item->setAboItem($aboitem);
        


		return $item;
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
	
    protected function getQuote($item)
    {
    	$customer = Mage::getModel('customer/customer')->load($item->getCustomerId());
    	Mage::getSingleton('customer/session')->setCustomerGroupId($customer->getGroupId());
		$quote = Mage::getModel('sales/quote');
		
		$storeId = $customer->getStoreId();		
		if (empty($storeId) || '' == $storeId) {
			$storeId = 0;//Mage::getStoreConfig('stalaabo/invoice/abo_invoice_store');
		}				
		$quote->setStoreId($storeId);
		$quote->reserveOrderId();
		
		$quote->setCustomer($customer);
		
		$billingAdr = $customer->getDefaultBillingAddress();

        
        $billingAdr = Mage::getModel('sales/quote_address')->importCustomerAddress($billingAdr);
        $billingAdr->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING);
        $quote->setBillingAddress($this->addressToQuoteAddress($billingAdr));
        $billingAdr->setQuote($quote);
        
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
        
        
        
        if($this->_customer)
        {
        	if($this->_customer->getId() != $quote->getCustomerId())
        	{
        		$this->_customer = Mage::getModel('customer/customer')->load($quote->getCustomerId());
        	}
        }
        else
        {
        	$this->_customer = Mage::getModel('customer/customer')->load($quote->getCustomerId());
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
	        		$periode_id = $orderItem->getPeriodId();
	        		if($periode_id)
	        		{
	        			$periode = Mage::getModel('periode/periode')->load($periode_id);
	        			/** @var $quoteItem Mage_Sales_Model_Quote_Item **/
	        			
	        			$quoteItem = $this->_findQuoteItem($quote, $orderItem->getQuoteItemId());	
	        			if($quoteItem){
		        			$enddate = $quoteItem->getOptionByCode('previous_periode_end');
		        			if($enddate){
			        			$enddate = $enddate->getValue();
			        			//$enddate= $item->getAboItem()->getStopDate();
				           		$orderItem->setPeriodStart($enddate);
				        		$orderItem->setPeriodEnd($periode->getEndDate(strtotime($enddate)));
				        		$orderItem->save();
		        			}
	        			}
	        		}
	        	}
	        	
	        	
		        if($first_increment_id){
		        	$order->setOriginalIncrementId($first_increment_id);
		        }
		        //$order->queueNewOrderEmail();
		        $order->save();
		        Mage::dispatchEvent('checkout_type_onepage_save_order_after',
		        		array('order'=>$order, 'quote'=>$quote));
	        }
	        $this->createNewAbo($order,$quote);
        }
        catch (Exception $ex)
        {
        	$this->onFailure($order,$quote, $ex);
        	Mage::logException($ex);
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
     * Einträge füe die Abos anlegen
     * @param Mage_Sales_Model_Order $order
     * @param Mage_Sales_Model_Quote $quote
     * @return Dwd_Abo_Model_Order_Abstract
     */
    public function createNewAbo($order,$quote)
    {
    	
    	//nur für automatische Verlängerungen
    	if(!$quote->getIsBatchOrder()){
    		return $this;
    	}
    	
    	
    	//gleich die neuen Abos anlegen
    	foreach ($quote->getAllItems() as $quoteitem)
    	{
    		 
    		$aboitem = $quoteitem->getAboItem();
    		if($aboitem != null)
    		{
	    		$orderitem = $order->getItemByQuoteItemId($quoteitem->getId());
	    		 
	    		//neues Abo erzeugen
	    		$abo = Mage::getModel('dwd_abo/abo');
	    		$abo->setFirstOrderId($aboitem->getFirstOrderId());
	    		$abo->setFirstOrderitemId($aboitem->getFirstOrderitemId());
	    		$abo->setCurrentOrderId($orderitem->getOrderId());
	    		$abo->setCurrentOrderitemId($orderitem->getId());
	    		$abo->setRenewalStatus(Dwd_Abo_Model_Renewalstatus::STATUS_PAUSE);
	    		$abo->setStatus(Dwd_Abo_Model_Status::STATUS_ACTIVE);
	    		$abo->setStartDate($orderitem->getPeriodStart());
	    		$abo->setStopDate($orderitem->getPeriodEnd());
	    		$p = Mage::getModel('periode/periode')->load($orderitem->getPeriodId());
	    		if($p->getId())
	    		{
	    			$p = intval($p->getCancelationPeriod());
	    		} else {
	    			$p = 14; //default 14 Tage Kündigungsfrist
	    		}
	    	
	    		 
	    		$date = new Zend_Date($orderitem->getPeriodEnd(), Varien_Date::DATETIME_INTERNAL_FORMAT, null);
	    		//$date = new Zend_Date(strtotime($orderitem->getPeriodEnd()));
	    		$date->add($p *-1, Zend_Date::DAY);
	    		$abo->setCancelationPeriodEnd($date);
	    		$abo->save();
	    	
	    		//ids switchen vor löschen des alten abos
	    		$abo->switchTierPriceDepends($aboitem);
	    	
	    		//beim speichern eines nicht aktiven des Abos werden die Staffelpreisabhängigkeiten gelöscht
	    		$aboitem->setRenewalStatus(Dwd_Abo_Model_Renewalstatus::STATUS_REORDERD);
	    		$aboitem->setStatus(Dwd_Abo_Model_Status::STATUS_EXPIRED);
	    		$aboitem->save();
    		}
    	
    		 
    	}
    	return $this;
    }
    
    /**
     * Fehlerbehandlung
     * @param Mage_Sales_Model_Order $order
     * @param Mage_Sales_Model_Quote $quote
     * @return Dwd_Abo_Model_Order_Abstract
     */
   
    public function onFailure($order,$quote, $ex = null)
    {
    	
    	
    	//nur für automatische Verlängerungen
    	if(!$quote->getIsBatchOrder()){
    		return $this;
    	}

    	if($order) {
            $order->setState(Mage_Sales_Model_Order::STATE_CANCELED, Mage_Sales_Model_Order::STATE_CANCELED, "Fehler bei der Aboverlängerung", false);
            $order->save();
        }
    	$aboIds = array();

    	foreach ($quote->getAllItems() as $quoteitem)
    	{
    	
    		$a = $quoteitem->getAboItem();
    		$aboIds[] = $a->getId();
    	}
    	$msg = "Die Abo(s) mit den Id(s) ". implode(',', $aboIds)." konnte(n) nicht verlängert werden." ;
    	
    	if($order) {
            $msg .= " Die Bestellung " . $order->getIncrementId() . " wurde storniert.";
        }
    	if($ex) {
            $msg .= " Meldung: " . $ex->getMessage();
        }
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
    
	public function sendMailToAdmin($body, $subject="Abo Fehler:") {
		if (strlen($body) > 0) 
		{
			$mailTo =  Mage::helper('egovsbase')->getAdminMail("dwd_abo/email/abo_email_address");
			$mailTo = explode(';', $mailTo);
			/* @var $mail Mage_Core_Model_Email */
			$mail = Mage::getModel('core/email');
			$shopName = Mage::getStoreConfig('general/imprint/shop_name');
			$body = sprintf("Shop Name: %s\nWebsite: %s\n\n%s", $shopName, Mage::getBaseUrl(), $body);
			$mail->setBody($body);
					
			$mail->setToEmail($mailTo);

			
			$sender = array();
			$sender['name'] = Mage::getStoreConfig("dwd_abo/email/abo_email_sender");
			$sender['email'] = Mage::getStoreConfig("dwd_abo/email/abo_email_address");
			
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
				Mage::log('AboModul::Email Absendername ist in der Konfiguration nicht gesetzt.', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			}
			
			if(strlen($sender['email']) < 2){
				Mage::log('AboModul::Email Absendemail ist in der Konfiguration nicht gesetzt.', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
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