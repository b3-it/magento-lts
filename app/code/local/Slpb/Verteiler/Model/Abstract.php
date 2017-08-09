<?php

class Slpb_Verteiler_Model_Abstract extends Mage_Core_Model_Abstract
{
    protected $_shippingmethod = "freeshipping_freeshipping";
	//protected $_paymentmethod = "openaccount";
	protected $_paymentmethod = "cashpayment";
	
	private $_customer = null;
	

	
	
	
	protected function getArtikelArt($product)
	{
		$lookup = Mage::getModel('eav/entity_attribute_source_table');
		$att = Mage::getModel('eav/entity_attribute');
		$att->loadByCode('catalog_product','artikel_art');
		$lookup->setAttribute($att);
		$res = $lookup->getOptionText($product->getArtikelArt());
		return $res;
	}

	
	
	protected function addItem($quote,$product,$qty)
	{
        $item = Mage::getModel('sales/quote_item');
        $item->setQuote($quote);
		$item->setQty($qty);
        $product->setData('website_id', 0);
		$item->setProduct($product);
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
	
    protected function getQuote($customer)
    {
    	
		$quote = Mage::getModel('sales/quote');
		
		$storeId = $customer->getStoreId();	
			
		$quote->setStoreId($storeId);

		$quote->reserveOrderId();
		
		$quote->setCustomer($customer);
		
		$billingAdr = $customer->getDefaultBillingAddress();
		//$billingAdr = clone $billingAdr;
        //$billingAdr->unsAddressId()->unsAddressType();
		$billingAdr = Mage::getModel('sales/quote_address')->importCustomerAddress($billingAdr);
        $billingAdr->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING);
        $billingAdr = $this->addressToQuoteAddress($billingAdr);
        
        $quote->setBillingAddress($billingAdr);
        $billingAdr->setQuote($quote);
        
        $shippingAdr = $customer->getDefaultShippingAddress();
		//$shippingAdr = clone $shippingAdr;
        //$shippingAdr->unsAddressId()->unsAddressType();
        $shippingAdr = Mage::getModel('sales/quote_address')->importCustomerAddress($shippingAdr);
        $shippingAdr->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING);
        $shippingAdr = $this->addressToQuoteAddress($shippingAdr);
  
        

        $shippingAdr->setShippingMethod($this->getShippingMethod())
                 ->setCollectShippingRates(true);
        $quote->setShippingAddress($shippingAdr);
        $shippingAdr->setQuote($quote);
        
        $quote->save();
  
        return $quote;
			
    }

    protected function addPaymentMethodeToQuote($quote, $paymentMethod)
    {   	        
        $payment = $quote->getPayment();
        $payment->setMethod($paymentMethod);
        $quote->getShippingAddress()->setPaymentMethod($payment->getMethod());
    }
    
    protected function getOrder($quote, $note = array())
    {
    	
    	$quote->getShippingAddress()->setCollectShippingRates(true);
    	$this->setRuleData($quote);
    	$quote->collectTotals()->save();
       
        $totals = $quote->getTotals();

       	if($totals['grand_total']['value'] < 0.01)
		{
			$this->addPaymentMethodeToQuote($quote,'free');
		
		}
        else 
        {
			$this->addPaymentMethodeToQuote($quote,$this->getPaymentMethod());
        }
        
        
        $quote->save();
		
        
        
        $quote->reserveOrderId();
        $convertQuote = Mage::getModel('sales/convert_quote');
 

		
        if ($quote->isVirtual()) {
            $order = $convertQuote->addressToOrder($quote->getBillingAddress());
        }
        else {
            $order = $convertQuote->addressToOrder($quote->getShippingAddress());
        }
		
		
        $order->setPayment($convertQuote->paymentToOrderPayment($quote->getPayment()));
        $order->save();
        
        $order->setBillingAddress($convertQuote->addressToOrderAddress($quote->getBillingAddress()));
		$order->setShippingAddress($convertQuote->addressToOrderAddress($quote->getShippingAddress()));
        
		if(isset($note[0])) $order->setPrintnote1($note[0]);
       	if(isset($note[1])) $order->setPrintnote2($note[1]);
        
        
        foreach ($quote->getAllItems() as $item) {
            $orderItem = $convertQuote->itemToOrderItem($item);
            if ($item->getParentItem()) {
                $orderItem->setParentItem($order->getItemByQuoteItemId($item->getParentItem()->getId()));
            }
            $order->addItem($orderItem);            
        }

        //$order->setData('shipping_carrier', Mage::getModel('Slpb_Shipping_Model_Carrier_Pickup'));
        
        /**
         * We can use configuration data for declare new order status
         */
        Mage::dispatchEvent('checkout_type_onepage_save_order', array('order'=>$order, 'quote'=>$quote));  
        Mage::dispatchEvent('sales_model_service_quote_submit_before', array('order'=>$order, 'quote'=>$quote));
        try {
        	$order->place();
        	$order->save();
        	Mage::dispatchEvent('sales_model_service_quote_submit_success', array('order'=>$order, 'quote'=>$quote));
        }
        catch (Exception $e) {
               
        	//reset order ID's on exception, because order not saved
        	$order->setId(null);
        	/** @var $item Mage_Sales_Model_Order_Item */
        	foreach ($order->getItemsCollection() as $item) {
        		$item->setOrderId(null);
        		$item->setItemId(null);
        	}
        
        	Mage::dispatchEvent('sales_model_service_quote_submit_failure', array('order'=>$order, 'quote'=>$quote));
        	throw $e;
        }
        //20111114::Frank Rochlitzer:: Die eCustomerID muss zurÃ¼ckgesetzt werden -> Caching Problem
        Mage::helper('paymentbase')->resetECustomerId();

        Mage::dispatchEvent('checkout_type_onepage_save_order_after', array('order'=>$order, 'quote'=>$quote));
        
        $quote->setIsActive(false);
        $quote->save();

        //Egovs_Helper::printMemUsage('getOrder=>');
        Mage::unregister('_singleton/salesrule/observer');
        return $order;
        
        
        
        
        
    }
    
    
    protected function getPaymentMethod()
    {   	        
        $methode = Mage::getStoreConfig('general/slpb/order_paymentmethod');
        if (!$methode)
        {
        	$methode = $this->_paymentmethod;
        }
        return $methode;
    }
    
    protected function getShippingMethod()
    {   	        
        $methode = Mage::getStoreConfig('general/slpb/order_shippingmethod');
        if (!$methode || empty($methode))
        {
        	$methode = $this->_shippingmethod;
        }
        return $methode;
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
    		$var->clear();
    		unset($var);
    	}
    	else 
    	{
    		unset($var);
    	}
    }
	
}