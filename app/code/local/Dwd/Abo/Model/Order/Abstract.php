<?php

class Dwd_Abo_Model_Order_Abstract extends Mage_Core_Model_Abstract
{
   
	/* @var $_SepaMandate Egovs_Paymentbase_Model_Sepa_Mandate */
	protected $_SepaMandate = null;
	
	
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
		
        $item = Mage::getModel('sales/quote_item');
        $item->setQuote($quote);
		$item->setQty(1);
		//$item->setData('stala_abo_shipping_address_id',intval($contractitem->getShippingAddressId()));

        $product->setData('website_id', 0);
        /* @var $item Mage_Sales_Model_Quote_Item */
        $item->addOption(array('code'=>'periode_id','value'=>$aboitem->getPeriodId()));
        $item->addOption(array('code'=>'station_id','value'=>$aboitem->getStationId()));
       
        $p = Mage::getModel('periode/periode')->load($aboitem->getPeriodId());
        $item->setPeriode($p);
        $item->setAboItem($aboitem);
        
		$item->setProduct($product);
		//$item->setStationId($contractitem->getStationId());
		
		
		
		$quote->addItem($item);

		return $item;
	}
	
	
	protected function setRuleData($quote)
	{
		//$customer = Mage::getModel('customer/customer')->load($quote->getCustomerId());
		//Wird fÃ¼r Katalogpreisregeln benÃ¶tigt
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
		
		$billingAdr = $customer->getDefaultBillingAddress();//Mage::getModel('customer/address')->load($item->getBillingAddressId());
		//$billingAdr = clone $billingAdr;
        //$billingAdr->unsAddressId()->unsAddressType();
        
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
        
        
        $quote->save();
		
        
        
       
        
        
        $quote->reserveOrderId();
        /* @var $convertQuote Mage_Sales_Model_Convert_Quote */
        $convertQuote = Mage::getModel('sales/convert_quote');
 
        if($quote->isVirtual())
        {
        	$order = $convertQuote->addressToOrder($quote->getBillingAddress());
        }
        else
        {
        	$order = $convertQuote->addressToOrder($quote->getShippingAddress());
        }
        $p = $convertQuote->paymentToOrderPayment($quote->getPayment());
                
        

        if($this->_customer)
        {
        	if($this->_customer->getId() != $order->getCustomerId())
        	{
        		$this->_customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
        	}
        }
        else
        {
        	$this->_customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
        }
        

        if( $lastSepa =  $payment->getLastSepaMethod())
        {
        	$ref =$lastSepa->getAdditionalInformation('mandate_reference');
	        if($ref != $this->_customer->getSepaMandateId()){
	        	$this->fillSepaDebitValues($p, $this->_customer);
	        }
	        else{
	        	$this->copySepaDebitValues($payment->getLastSepaMethod(), $p);
	        }
        }
        $order->setPayment($p);
        $order->save();
        /* @var $order Mage_Sales_Model_Order */
        $order->setBillingAddress($convertQuote->addressToOrderAddress($quote->getBillingAddress()));
        $baseAdr = $quote->getBaseAddress();
        if($baseAdr)
        {
        	$order->setBaseAddress($convertQuote->addressToOrderAddress($baseAdr));
        }
		//$order->setShippingAddress($convertQuote->addressToOrderAddress($quote->getShippingAddress()));
        

        
        /*
        $order->setPrintnote1($this->_customer->getAboPrintNote1());
       	$order->setPrintnote2($this->_customer->getAboPrintNote2());
        
        $order->setIsAbo('1');
        */
        
        foreach ($quote->getAllItems() as $item) {
            $orderItem = $convertQuote->itemToOrderItem($item);
            if ($item->getParentItem()) {
                $orderItem->setParentItem($order->getItemByQuoteItemId($item->getParentItem()->getId()));
            }
            $orderItem->setPeriodId($item->getPeriode()->getId());
            $orderItem->setPeriodType($item->getPeriode()->getType());
            $orderItem->setPeriodStart($item->getAboItem()->getStopDate());
            $orderItem->setPeriodEnd($item->getPeriode()->getEndDate(strtotime($item->getAboItem()->getStopDate())));
            $orderItem->setIbewiMaszeinheit($item->getProduct()->getIbewiMaszeinheit());
            $orderItem->setStoreId($order->getStoreId());
            $order->addItem($orderItem);            
        }
		$order->save();
       
        
        /**
         * We can use configuration data for declare new order status
         */
        Mage::dispatchEvent('checkout_type_onepage_save_order', array('order'=>$order, 'quote'=>$quote));  
        Mage::dispatchEvent('sales_model_service_quote_submit_before', array('order'=>$order, 'quote'=>$quote));
    	try {
				$order->place();
				if($first_increment_id){
					$order->setOriginalIncrementId($first_increment_id);
				}
				
				$order->save();
				Mage::dispatchEvent('sales_model_service_quote_submit_success', array('order'=>$order, 'quote'=>$quote));
			}
			catch(Exception $ex)
			{
				Mage::dispatchEvent('sales_model_service_quote_submit_success', array('order'=>$order, 'quote'=>$quote));
				$quote->setIsActive(false);
				$quote->save();
				
				$order->setState(Mage_Sales_Model_Order::STATE_CANCELED, Mage_Sales_Model_Order::STATE_CANCELED,"Fehler bei der Aboverlängerung",false);
				$order->save();
				$aboIds = array();
				foreach ($quote->getAllItems() as $quoteitem)
				{
					 
					$a = $quoteitem->getAboItem();
					$aboIds[] = $a->getId();
				}
				$msg = "Die Abo(s) mit den Id(s) ". implode(',', $aboIds)." konnte(n) nicht verlängert werden." ;
				$msg .= " Die Bestellung " . $order->getIncrementId() ." wurde storniert.";
				$msg .= " Meldung: " . $ex->getMessage();
				$this->sendMailToAdmin($msg);
				
				Mage::dispatchEvent('sales_model_service_quote_submit_failure', array('order'=>$order, 'quote'=>$quote));
				throw $ex;
				
			}     
        
        //20111114::Frank Rochlitzer:: Die eCustomerID muss zurÃ¼ckgesetzt werden -> Caching Problem
        Mage::helper('paymentbase')->resetECustomerId();

        Mage::dispatchEvent('checkout_type_onepage_save_order_after', array('order'=>$order, 'quote'=>$quote));

        /**
         * need to have somelogic to set order as new status to make sure order is not finished yet
         * quote will be still active when we send the customer to paypal
         */

       
        
        $quote->setIsActive(false);
        $quote->save();

        //Egovs_Helper::printMemUsage('getOrder=>');
        Mage::unregister('_singleton/salesrule/observer');

        
        //gleich die neuen Abos anlegen
        foreach ($quote->getAllItems() as $quoteitem) 
        {
        	
        	$aboitem = $quoteitem->getAboItem();
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
        return $order;
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
			
			$sdm = Mage::getStoreConfig('payment/paymentbase/webshopdesmandanten');
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