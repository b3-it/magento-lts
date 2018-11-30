<?php


class Slpb_Checkout_Model_Shop extends Slpb_Checkout_Model_Abstract
{
	
	protected $_shippingmethod = "storepickup_storepickup";
	protected $_paymentmethod = "cashpayment";

	public function setPaymentMethode($value)
	{
		$this->_paymentmethod = $value;
	}
	
	public function setShippingMethode($value)
	{
		$this->_shippingmethod = $value;
	}
	
    /**
     *
     * @param Mage_Customer_Model_Resource_Address $data
     * @return bool
     */
    public function saveAddress($data)
    {
        if (empty($data)) {
        	 Mage::throwException(Mage::helper('checkout')->__('Invalid data'));
        }
         $this->getQuote()->getShippingAddress()->setSameAsBilling(true);
        //kundennummer
        if($data['customerident'] != 1)
        {
           	
        	$customerId = $this->decodeCustumerId($data['customernumber']);
        	$customer = Mage::getModel('customer/customer')->Load($customerId);
        	if($customer->getId()!= $customerId)
        	{
        		Mage::throwException(Mage::helper('checkout')->__('Invalid Customer'));
        	}
        	$customerAddressId = $customer->getDefaultBilling();
			$address = $this->getQuote()->getBillingAddress();
        	$customerAddress = Mage::getModel('customer/address')->load($customerAddressId);
           	$customerId = $customerAddress->getCustomerId(); 
          	$this->getQuote()->setCustomerId($customerId);
            $address->importCustomerAddress($customerAddress);
        }
        else
        {
        
	    	if(($res = $this->validateAddress($data)) !== true){
	    		Mage::throwException($res);
	    	}
	    	
	    	$data = $this->normalizeAddress($data);
	    	$customerAddressId = $this->getCustomerAddressId($data);
	   		$customerId = 0;    	
	        $address = $this->getQuote()->getBillingAddress();
	        
	        if ($customerAddressId != 0) 
	        {
	            $customerAddress = Mage::getModel('customer/address')->load($customerAddressId);
	            if ($customerAddress->getId()) {
	            	$customerId = $customerAddress->getCustomerId(); 
	            	$this->getQuote()->setCustomerId($customerId);
	              
	                $address->importCustomerAddress($customerAddress);
	            }
	        } 
	        else 
	        {
	          unset($data['address_id']);
	 
	            $address->addData($data);
	            //scheint sinnlos - loest aber die regionid in einen namen auf
	            $address->unsRegionId();
	            if(isset($data['region'])) $address->getRegionId();
	            if(($data['country_id']!='DE') && ($address->getRegion()!= null))
	            {
	            	$address->setRegion('');
	            }
	            
	            $dummy = Slpb_Checkout_Model_Abstract::DummyEmailDomain;
	            $email = Mage::helper('slpbcheckout')->getRandomString().base_convert(time(),10,16)."@$dummy";
	            while($this->_customerEmailExists($email, Mage::app()->getWebsite()->getId())) 
	            {
	            	$email = Mage::helper('slpbcheckout')->getRandomString().base_convert(time(),10,16)."@$dummy";
	            }
	         
	            $address->setEmail($email);
	            
	        }
        }
        
        
       
        
      	//test it again
        $testing = Mage::getModel('slpbproduct/checkout_observer');
        $testing->testCart($this->getQuote()->getAllVisibleItems(), $this->getQuote()->getBillingAddress());
        
        if($customerId != 0)
        {
       		$testing->testPeriod($customerId); 
        }
        
        $billing = clone $address;
        $billing->unsAddressId()->unsAddressType();
        $this->getQuote()->getShippingAddress()->addData($billing->getData())
                 ->setSameAsBilling(1)
                 ->setShippingMethod($this->_shippingmethod)
                 ->setCollectShippingRates(true);
       
        $this->getQuote()->collectTotals();
       
        
        
        $this->getQuote()->save();
		$this->saveOrder($customerId);
 		
        return true;
    }

  
    /**
     * Enter description here...
     *
     * @return array
     */
    public function saveOrder($customerId = 0)
    {
    	$this->getQuote()->collectTotals()->save();
        //$this->validateOrder($sendOrderEmail);
        $billing = $this->getQuote()->getBillingAddress();
        $shipping = $this->getQuote()->getShippingAddress();
      
        $quote = $this->getQuote();
        
 
        
        if($customerId == 0)
        {
            $customer = Mage::getModel('customer/customer');
            /* @var $customer Mage_Customer_Model_Customer */

            $customerBilling = $billing->exportCustomerAddress();
            
            $customer->addAddress($customerBilling);

            $customerShipping = $shipping->exportCustomerAddress();
            $customer->addAddress($customerShipping);
 
 
            //Mage::helper('core')->copyFieldset('checkout_onepage_billing', 'to_customer', $billing, $customer);

            $this->getQuote()->setPasswordHash($customer->encryptPassword( Mage::helper('slpbcheckout')->getRandomString(10)));
			$customer->setPassword($customer->decryptPassword($this->getQuote()->getPasswordHash()));
        	$customer->setPasswordHash($customer->hashPassword($customer->getPassword()));

        	//$this->_processValidateCustomer($address);
        	Mage::helper('core')->copyFieldset('checkout_onepage_billing', 'to_customer', $billing, $customer);
        	
        	//save to get the addresses Id's
        	$customer->save();
          
        	$customer->setDefaultBilling($customerBilling->getId());
        	$customer->setDefaultShipping($customerShipping->getId());
        	
        	$customer->save();
            
        }
        else
        {
            $customer = Mage::getModel('customer/customer')->Load($customerId);
			//$customerBillingId = $customer->getDefaultBilling();
			//$customerBillingId = $customerBilling->getId();
			
        }
        
        
        Mage::getSingleton('customer/session')->setCustomerGroupId($customer->getGroupId());
        $quote->setCustomer($customer);       
 		$quote->collectTotals()->save();
    	$totals = $this->getQuote()->getTotals();

       	if($totals['grand_total']['value'] < 0.01)
		{
			$this->addPaymentMethode('free');
		
		}
        else 
        {
			$this->addPaymentMethode($this->_paymentmethod);
        }
        
 		
        
        $quote->reserveOrderId();
        $convertQuote = Mage::getModel('sales/convert_quote');
                
        /* @var $order Mage_Sales_Model_Order */
        
        $order = $convertQuote->addressToOrder($shipping);
        $order->setQuote($quote);
        $order->setBillingAddress($convertQuote->addressToOrderAddress($billing));
		$order->setShippingAddress($convertQuote->addressToOrderAddress($shipping));
 		    

        $order->setPayment($convertQuote->paymentToOrderPayment($this->getQuote()->getPayment()));
        if (Mage::app()->getStore()->roundPrice($shipping->getGrandTotal()) == 0) {
        	$order->getPayment()->setMethod('free');
        }
        
        
        foreach ($this->getQuote()->getAllItems() as $item) {
            $orderItem = $convertQuote->itemToOrderItem($item);
            if ($item->getParentItem()) {
                $orderItem->setParentItem($order->getItemByQuoteItemId($item->getParentItem()->getId()));
            }
            $order->addItem($orderItem);
        }

        ///$order->setData('shipping_carrier', Mage::getModel('Slpb_Shipping_Model_Carrier_Pickup'));
        
        $order->save();
        
        /**
         * We can use configuration data for declare new order status
         */
        Mage::dispatchEvent('checkout_type_onepage_save_order', array('order'=>$order, 'quote'=>$this->getQuote()));
        Mage::dispatchEvent('sales_model_service_quote_submit_before', array('order'=>$order, 'quote'=>$this->getQuote()));
        // check again, if customer exists
        if ($this->getQuote()->getCheckoutMethod() == Mage_Sales_Model_Quote::CHECKOUT_METHOD_REGISTER) {
            if ($this->_customerEmailExists($customer->getEmail(), Mage::app()->getWebsite()->getId())) {
                Mage::throwException(Mage::helper('checkout')->__('There is already a customer registered using this email address'));
            }
        }
        $order->place();
        
	    Mage::getSingleton('customer/session')->unsetData('customer_group_id');
		Mage::getSingleton('customer/session')->unsetData('addresspostdata');
		
       	$this->getQuote()->setCustomerId($customer->getId());

       	$order->setCustomerId($customer->getId());
      	Mage::helper('core')->copyFieldset('customer_account', 'to_order', $customer, $order);

      	/*
      	$billing->setCustomerId($customer->getId())
      			->setCustomerAddressId($customerBillingId);
 		*/
        

        $order->save();

        Mage::dispatchEvent('checkout_type_onepage_save_order_after', array('order'=>$order, 'quote'=>$this->getQuote()));

        /**
         * need to have somelogic to set order as new status to make sure order is not finished yet
         * quote will be still active when we send the customer to paypal
         */

        $orderId = $order->getIncrementId();
        $this->getCheckout()->setLastQuoteId($this->getQuote()->getId());
        $this->getCheckout()->setLastOrderId($order->getId());
        $this->getCheckout()->setLastRealOrderId($order->getIncrementId());
       
 
        //Setting this one more time like control flag that we haves saved order
        //Must be checkout on success page to show it or not.
        $this->getCheckout()->setLastSuccessQuoteId($this->getQuote()->getId());

        $this->getQuote()->setIsActive(false);
        $this->getQuote()->save();

        return $this;
    }

 
 
    
}
