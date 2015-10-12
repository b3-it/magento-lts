<?php

class Stala_Abo_Model_Abstract extends Mage_Core_Model_Abstract
{
    protected $_shippingmethod = null;//"freeshipping_freeshipping";
	protected $_paymentmethod = null;//"openaccount";
	//protected $_paymentmethod = "cashpayment";
	
	private $_customer = null;
	
	public function setPaymentMethode($value)
	{
		$this->_paymentmethod = $value;
		return $this;
	}
	
	public function setShippingMethode($value)
	{
		$this->_shippingmethod = $value;
		return $this;
	}
	
	
	public function getPaymentMethode()
	{
		if($this->_paymentmethod == null)
		{
			$this->_paymentmethod = Mage::getStoreConfig('stalaabo/invoice/abo_invoice_paymentmethod');
		}
		return $this->_paymentmethod;
	}
	
	public function getShippingMethode()
	{
		if($this->_shippingmethod == null)
		{
			$this->_shippingmethod = Mage::getStoreConfig('stalaabo/invoice/abo_invoice_shippingmethod');
		}
		return $this->_shippingmethod;
	}
	
	protected function getArtikelArt($product)
	{
		$lookup = Mage::getModel('eav/entity_attribute_source_table');
		$att = Mage::getModel('eav/entity_attribute');
		$att->loadByCode('catalog_product','artikel_art');
		$lookup->setAttribute($att);
		$res = $lookup->getOptionText($product->getArtikelArt());
		return $res;
	}

	
	
	protected function addItem($quote,$contractitem)
	{
		$product = Mage::getModel('catalog/product')->load($contractitem->getProductId());
		$stock = $product->getStockItem();
  		if(($stock->getManageStock()) && (!$stock->getManageStock($contractitem->getShippingQty())))
  		{
  			$txt = Mage::helper('stalaabo')->__('Action canceled! Product is out of stock!');
  			Mage::throwException($txt.'(ID: '.$product->getId().')');
  		}
        $item = Mage::getModel('sales/quote_item');
        $item->setQuote($quote);
		$item->setQty($contractitem->getContractQty());
		$item->setData('stala_abo_shipping_address_id',intval($contractitem->getShippingAddressId()));

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
	
    protected function getQuote($item)
    {
    	$customer = Mage::getModel('customer/customer')->load($item->getCustomerId());
    	
		$quote = Mage::getModel('sales/quote');
		
		$storeId = $customer->getStoreId();		
		if (empty($storeId) || '' == $storeId) {
			$storeId = Mage::getStoreConfig('stalaabo/invoice/abo_invoice_store');
		}				
		$quote->setStoreId($storeId);
		//$quote->setReservedOrderId('abo');
		$quote->reserveOrderId();
		
		$quote->setCustomer($customer);
		
		$billingAdr = Mage::getModel('customer/address')->load($item->getBillingAddressId());
		$billingAdr = clone $billingAdr;
        $billingAdr->unsAddressId()->unsAddressType();
        $billingAdr->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING);
        $quote->setBillingAddress($this->addressToQuoteAddress($billingAdr));
        $billingAdr->setQuote($quote);
        
        $shippingAdr = Mage::getModel('customer/address')->load($item->getShippingAddressId());
		$shippingAdr = clone $shippingAdr;
        $shippingAdr->unsAddressId()->unsAddressType();
        $shippingAdr->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING);
        $quote->setShippingAddress($this->addressToQuoteAddress($shippingAdr));
        $shippingAdr->setQuote($quote);
        

        $shippingAdr->setShippingMethod($this->getShippingMethode())
                 ->setCollectShippingRates(true);
        
        $quote->save();
        return $quote;
			
    }
    
    
    protected function getOrder($quote)
    {
    	//Egovs_Helper::printMemUsage('getOrder<=');
    	$quote->getShippingAddress()->setCollectShippingRates(true);
    	$this->setRuleData($quote);
    	$quote->collectTotals()->save();
       
        $totals = $quote->getTotals();
       
       	if($totals['grand_total']['value'] < 0.01)
		{
			$this->addPaymentMethode($quote,'free');
		
		}
        else 
        {
			$this->addPaymentMethode($quote,$this->getPaymentMethode());
        }
        
        
        $quote->save();
		
        
        
        $quote->reserveOrderId();
        $convertQuote = Mage::getModel('sales/convert_quote');
 
        if($quote->isVirtual())
        {
        	$order = $convertQuote->addressToOrder($quote->getBillingAddress());
        }
        else
        {
        	$order = $convertQuote->addressToOrder($quote->getShippingAddress());
        }
        $order->setPayment($convertQuote->paymentToOrderPayment($quote->getPayment()));
        $order->save();
        /* @var $order Mage_Sales_Model_Order */
        $order->setBillingAddress($convertQuote->addressToOrderAddress($quote->getBillingAddress()));
		$order->setShippingAddress($convertQuote->addressToOrderAddress($quote->getShippingAddress()));
        

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
        
        
        $order->setPrintnote1($this->_customer->getAboPrintNote1());
       	$order->setPrintnote2($this->_customer->getAboPrintNote2());
        
        $order->setIsAbo('1');
        foreach ($quote->getAllItems() as $item) {
            $orderItem = $convertQuote->itemToOrderItem($item);
            if ($item->getParentItem()) {
                $orderItem->setParentItem($order->getItemByQuoteItemId($item->getParentItem()->getId()));
            }
            $order->addItem($orderItem);            
        }
		$order->save();
       
        
        /**
         * We can use configuration data for declare new order status
         */
        Mage::dispatchEvent('checkout_type_onepage_save_order', array('order'=>$order, 'quote'=>$quote));  
        $order->place();
        $order->save();
        
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
        return $order;
        
        
        
        
        
    }
    
    
    protected function addPaymentMethode($quote, $paymentMethod)
    {   	        
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
	
}