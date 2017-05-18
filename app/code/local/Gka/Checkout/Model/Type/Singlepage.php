<?php

class Gka_Checkout_Model_Type_Singlepage extends Gka_Checkout_Model_Type_Abstract
{

    /**
     * Quote shipping addresses items cache
     *
     * @var array
     */
    protected $_quoteShippingAddressesItems;


    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_init();
    }

    /**
     * Initialize checkout.
     * @return Gka_Checkout_Model_Type_Singlepage
     */
    protected function _init()
    {
        /**
         * reset quote shipping addresses and items
         */
        $quote = $this->getQuote();
        if (!$this->getCustomer()->getId()) {
            return $this;
        }

        if ($this->getCheckoutSession()->getCheckoutState() === Mage_Checkout_Model_Session::CHECKOUT_STATE_BEGIN) {
            $this->getCheckoutSession()->setCheckoutState(true);
            /**
             * Remove all addresses
             */
            $addresses  = $quote->getAllAddresses();
            foreach ($addresses as $address) {
                $quote->removeAddress($address->getId());
            }

            if ($defaultShipping = $this->getCustomerDefaultShippingAddress()) {
                $quote->getShippingAddress()->importCustomerAddress($defaultShipping);

                foreach ($this->getQuoteItems() as $item) {
                    /**
                     * Items with parent id we add in importQuoteItem method.
                     * Skip virtual items
                     */
                    if ($item->getParentItemId() || $item->getProduct()->getIsVirtual()) {
                        continue;
                    }
                    $quote->getShippingAddress()->addItem($item);
                }
            }

            if ($this->getCustomerDefaultBillingAddress()) {
                $quote->getBillingAddress()
                    ->importCustomerAddress($this->getCustomerDefaultBillingAddress());
                foreach ($this->getQuoteItems() as $item) {
                    if ($item->getParentItemId()) {
                        continue;
                    }
                    if ($item->getProduct()->getIsVirtual()) {
                        $quote->getBillingAddress()->addItem($item);
                    }
                }
            }
            $this->save();
        }
        return $this;
    }


    /**
     * Set payment method info to quote payment
     *
     * @param array $payment
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function setPaymentMethod($method)
    {
        
        $quote = $this->getQuote();
        $quote->getPayment()->importData(array('method'=>$method));
        // shipping totals may be affected by payment method
        if (!$quote->isVirtual() && $quote->getShippingAddress()) {
            $quote->getShippingAddress()->setCollectShippingRates(true);
            $quote->setTotalsCollectedFlag(false)->collectTotals();
        }
        $quote->save();
        return $this;
    }
    

    /**
     * Prepare order based on quote address
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @return  Mage_Sales_Model_Order
     * @throws  Mage_Checkout_Exception
     */
    protected function _prepareOrder(Mage_Sales_Model_Quote_Address $address)
    {
        $quote = $this->getQuote();
        $quote->unsReservedOrderId();
        $quote->reserveOrderId();
        $quote->collectTotals();

        $convertQuote = Mage::getSingleton('sales/convert_quote');
        $order = $convertQuote->addressToOrder($address);
        $order->setQuote($quote);
        $order->setBillingAddress(
            $convertQuote->addressToOrderAddress($quote->getBillingAddress())
        );

        if ($address->getAddressType() == 'billing') {
            $order->setIsVirtual(1);
        } else {
            $order->setShippingAddress($convertQuote->addressToOrderAddress($address));
        }

        $order->setPayment($convertQuote->paymentToOrderPayment($quote->getPayment()));
        if (Mage::app()->getStore()->roundPrice($address->getGrandTotal()) == 0) {
            $order->getPayment()->setMethod('free');
        }

        $los = null;
        foreach ($address->getAllItems() as $item) {
            $_quoteItem = $item->getQuoteItem();
            if (!$_quoteItem) {
                throw new Mage_Checkout_Exception(Mage::helper('checkout')->__('Item not found or already ordered'));
            }
            $item->setProductType($_quoteItem->getProductType())
                ->setProductOptions(
                    $_quoteItem->getProduct()->getTypeInstance(true)->getOrderOptions($_quoteItem->getProduct())
                );
            $orderItem = $convertQuote->itemToOrderItem($item);
            $orderItem->setStoreGroup($_quoteItem->getStoreGroup());
            
           
            
            if ($item->getParentItem()) {
                $orderItem->setParentItem($order->getItemByQuoteItemId($item->getParentItem()->getId()));
            }
            
            $order->addItem($orderItem);
        }
       
        

        return $order;
    }

    /**
     * Validate quote data
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    protected function _validate()
    {
        $helper = Mage::helper('gkacheckout');
        $quote = $this->getQuote();
       
        /** @var $paymentMethod Mage_Payment_Model_Method_Abstract */
        $paymentMethod = $quote->getPayment()->getMethodInstance();
        if (!empty($paymentMethod) && !$paymentMethod->isAvailable($quote)) {
            Mage::throwException($helper->__('Please specify payment method.'));
        }
        return $this;
    }

    
  
    public function setShippingMethod()
    {
    	$addresses = $this->getQuote()->getAllShippingAddresses();
    	foreach ($addresses as $address)
    	{
    		$address->setShippingMethod($this->getShippingMethod());
    		//wichtig damit die ShippingRates geladen werden
    		$address->requestShippingRates();
    		$address->save();
    	}
    	return $this;
    }
    
    public function setBillingAddress($data)
    {
    	/** @var $address Mage_Sales_Model_Quote_address */
    	$address  = $this->getQuote()->getBillingAddress();
    	
    	if($address == null)
    	{
	    	$address = Mage::getModel('sales/quote_address');
	    	$address
	    	->importCustomerAddress(new Mage_Customer_Model_Address($data))
	    	->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_BILLING)
	    	->setQuote($this->getQuote())
	    	->save();
	    	$this->getQuote()->setBillingAddress($address)->save();
    	}
    	else
    	{
    		foreach($data as $k=>$v)
    		{
    			$address->setData($k,$v);
    		}
    		$address->setStreet($data['street'])
    			->save();
    	}
    	
    	return $this;
    }
    
    public function setShippingAddress($data)
    {
    	/** @var $address Mage_Sales_Model_Quote_address */
    	$address  = $this->getQuote()->getShippingAddress();
    	 
    	if($address == null)
    	{
    		$address = Mage::getModel('sales/quote_address');
    		$address
    		->importCustomerAddress(new Mage_Customer_Model_Address($data))
    		->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING)
    		->setQuote($this->getQuote())
    		->save();
    		$this->getQuote()->setShippingAddress($address)->save();
    	}
    	else
    	{
    		foreach($data as $k=>$v)
    		{
    			$address->setData($k,$v);
    		}
    		$address->setStreet($data['street'])
    		->save();
    	}
    	 
    	return $this;
    }
    
    /**
     * Create orders per each quote address
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function createOrder($givenamount)
    {
        $orderIds = array();
        $this->_validate();

        $address = $this->getQuote()->getBillingAddress();;
        
        
        try {
        
        	$order = $this->_prepareOrder($address);
			$order->setGivenAmount($givenamount);
               
            Mage::dispatchEvent(
                    'checkout_type_multishipping_create_orders_single',
                    array('order'=>$order, 'address'=>$address)
                );
      

             $order->place();
             $order->save();
             //if ($order->getCanSendNewEmailFlag()){
             //       $order->sendNewOrderEmail();
             //   }
            $orderIds[$order->getId()] = $order->getIncrementId();


            Mage::getSingleton('core/session')->setOrderIds($orderIds);
            Mage::getSingleton('checkout/session')->setLastQuoteId($this->getQuote()->getId());

            $this->getQuote()
                ->setIsActive(false)
                ->save();

            Mage::dispatchEvent('checkout_submit_all_after', array('order' => $order, 'quote' => $this->getQuote()));

            return $this;
        } catch (Exception $e) {
            //Mage::dispatchEvent('checkout_multishipping_refund_all', array('orders' => $orders));
            Mage::logException($e);
            throw $e;
        }
    }

    /**
     * Collect quote totals and save quote object
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function save()
    {
        $this->getQuote()->collectTotals()
            ->save();
        return $this;
    }

    /**
     * Specify BEGIN state in checkout session whot allow reinit multishipping checkout
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function reset()
    {
        $this->getCheckoutSession()->setCheckoutState(Mage_Checkout_Model_Session::CHECKOUT_STATE_BEGIN);
        return $this;
    }

    /**
     * Check if quote amount is allowed for multishipping checkout
     *
     * @return bool
     */
    public function validateMinimumAmount()
    {
        return !(Mage::getStoreConfigFlag('sales/minimum_order/active')
            && Mage::getStoreConfigFlag('sales/minimum_order/multi_address')
            && !$this->getQuote()->validateMinimumAmount());
    }

    /**
     * Get notification message for case when multishipping checkout is not allowed
     *
     * @return string
     */
    public function getMinimumAmountDescription()
    {
        $descr = Mage::getStoreConfig('sales/minimum_order/multi_address_description');
        if (empty($descr)) {
            $descr = Mage::getStoreConfig('sales/minimum_order/description');
        }
        return $descr;
    }

    public function getMinimumAmountError()
    {
        $error = Mage::getStoreConfig('sales/minimum_order/multi_address_error_message');
        if (empty($error)) {
            $error = Mage::getStoreConfig('sales/minimum_order/error_message');
        }
        return $error;
    }

    /**
     * Function is deprecated. Moved into helper.
     *
     * Check if multishipping checkout is available.
     * There should be a valid quote in checkout session. If not, only the config value will be returned.
     *
     * @return bool
     */
    public function isCheckoutAvailable()
    {
        return Mage::helper('checkout')->isMultishippingCheckoutAvailable();
    }

    /**
     * Get order IDs created during checkout
     *
     * @param bool $asAssoc
     * @return array
     */
    public function getOrderIds($asAssoc = false)
    {
        $idsAssoc = Mage::getSingleton('core/session')->getOrderIds();
        return $asAssoc ? $idsAssoc : array_keys($idsAssoc);
    }
    
 
    
}
