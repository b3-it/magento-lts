<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Multishipping checkout model
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sid_Checkout_Model_Type_Multishipping extends Sid_Checkout_Model_Type_Abstract
{

    /**
     * Quote shipping addresses items cache
     *
     * @var array
     */
    protected $_quoteShippingAddressesItems;

    /**
     * die in der Overview eingegebene Bezeichner pro Adresse
     * @var array
     */
    protected $_vergabenummern = array();
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->_init();
    }

    /**
     * Initialize multishipping checkout.
     * Split virtual/not virtual items between default billing/shipping addresses
     *
     * @return Mage_Checkout_Model_Type_Multishipping
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

   
    
   public function getQuoteShippingAddressesItemsAssigned()
    {
        $items = array();
        foreach ( $this->getAssigned() as $assigned) 
        {
        	$item = $this->getQuote()->getItemById($assigned['quoteitemid']);
        	if(($item) && ($assigned['qty'] > 0) && !$item->getIsVirtual())
        	{
				$obj = new Varien_Object();
				$obj->setQty($assigned['qty']);
	        	$item = $this->getQuote()->getItemById($assigned['quoteitemid']);
	        	$obj->setProduct($item->getProduct());
	        	$obj->setQuoteItemId($assigned['quoteitemid']);
	        	$obj->setAddressId($assigned['adr']);
	        	
	        	$items[] = $obj;
        	}
        }
      
        return $items;
    }
 	
    public function getQuoteShippingAddressesItemsUnAssigned()
    {
        $items = array();
            foreach ($this->getQuote()->getAllItems() as $item) {
                if ($item->getParentItemId()) {
                    continue;
                }
                if ($item->getProduct()->getIsVirtual()) {
                    //$items[] = $item;
                    continue;
                } 
              
                $qty = $this->getQuoteItemQty($item);
                if( $qty > 0)
                {
                    $item->setCalcQty($qty);
                    $items[] = $item;
                }
                
            }
        
        return $items;
    }
    
    
    public function resetAssigned()
    {
    	$this->getCheckoutSession()->unsetData('assigned');
    	return $this;
    }
    
    public function getAssigned()
    {
    	$assigned = $this->getCheckoutSession()->getData('assigned',false);
        if($assigned == null) $assigned = array();
        return $assigned;
    }
    
    
    private function getQuoteItemQty($quoteitem)
    {
    	$qty = $quoteitem->getQty();
    	foreach ( $this->getAssigned() as $assigned) 
        {
        	if($quoteitem->getId() == $assigned['quoteitemid'])
        	{
        		$qty -= $assigned['qty'];
        	}
        }
        
        return $qty;
    }
    
    
    public function takeItems($quoteitemid,$adr,$qty)
    {
    
    	$assigned = $this->getAssigned();
    	$key = $quoteitemid.'_'.$adr;

    	$item = $this->getQuote()->getItemById($quoteitemid);
    	
    	if ($qty < 1) return;
    	if(isset($assigned[$key]))
    	{
    		if($item->getQty() < $assigned[$key]['qty'] + $qty)
    		{
    			$assigned[$key]['qty'] = $item->getQty();
    		}
    		else
    		{
    			$assigned[$key]['qty'] += $qty;
    		}
    	}
    	else
    	{
    		if($item->getQty() < $qty)
    		{
    			$qty = $item->getQty();
    		}
    		$assigned[$key] = array('qty'=>$qty, 'adr'=>$adr, 'quoteitemid' =>$quoteitemid);		
    	}
		$this->getCheckoutSession()->setData('assigned',$assigned);
    }
    
    
  
    
   public function putbackItems($quoteitemid,$adr,$qty)
    {
        $assigned = $this->getAssigned();
    	$key = $quoteitemid.'_'.$adr;
    	if(isset($assigned[$key]))
    	{
    		$assigned[$key]['qty'] -= $qty;
    		if($assigned[$key]['qty'] < 0 ) $assigned[$key]['qty'] = 0;
    		$this->getCheckoutSession()->setData('assigned',$assigned);
    	}
    }
    
    
    
    
    public function moveAssignedItemsToQuote()
    {
    	//alle Lieferadressen entfernen	
        $addresses  = $this->getQuote()->getAllShippingAddresses();
        foreach ($addresses as $address) 
        {
         	$this->getQuote()->removeAddress($address->getId());
        }
        $this->getQuote()->save();

        foreach ($this->getAssigned() as $assigned) 
        {
        	if (!$address = $this->getQuote()->getShippingAddressByCustomerAddressId($assigned['adr'])) 
        	{
                    $address = $this->getNewShippingAddress($assigned['adr']);
                    
        	}
        		$item = $this->getQuote()->getItemById($assigned['quoteitemid']);
                if ($item->getParentItemId()) {
                    continue;
                }
                if ($item->getProduct()->getIsVirtual()) {
                    continue;
                }
                if ($item->getQty() < $assigned['qty']) 
                {
                	$quoteItem = clone $item; 
                	$quoteItem->save();            	
                    $address->addItem($quoteItem,$assigned['qty']);
                    $item->setQty($item->getQty() - $assigned['qty']);
                }
                else 
                {
                	$address->addItem($item,$assigned['qty']);
                }
            
            if (!$address->hasItems()) {
                   $address->isDeleted(true);
                }
              $address->setCollectShippingRates((boolean) $this->getCollectRatesFlag()); 
             $address->save();
             
        }
        	
        	
    	
        $this->getQuote()
        	->setTotalsCollectedFlag(false)
        	->collectTotals()
        	->save(); 

    }
    
    private function getNewShippingAddress($customerAddressId)
    {
    	$adr = Mage::getModel('customer/address')->load($customerAddressId);
        $address = Mage::getModel('sales/quote_address')->importCustomerAddress($adr);
        $address->setAddressType(Mage_Sales_Model_Quote_Address::TYPE_SHIPPING)
                 ->setSameAsBilling(false)
                 ->setQuote($this->getQuote());
         $this->getQuote()->addAddress($address)->save();
         return $address;
    }
    
    /**
     * Remove item from address
     *
     * @param int $addressId
     * @param int $itemId
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function removeAddressItem($addressId, $itemId)
    {
        $address = $this->getQuote()->getAddressById($addressId);
        /* @var $address Mage_Sales_Model_Quote_Address */
        if ($address) {
            $item = $address->getValidItemById($itemId);
            if ($item) {
                if ($item->getQty()>1 && !$item->getProduct()->getIsVirtual()) {
                    $item->setQty($item->getQty()-1);
                } else {
                    $address->removeItem($item->getId());
                }

                /**
                 * Require shiping rate recollect
                 */
                $address->setCollectShippingRates((boolean) $this->getCollectRatesFlag());

                if (count($address->getAllItems()) == 0) {
                    $address->isDeleted(true);
                }

                if ($quoteItem = $this->getQuote()->getItemById($item->getQuoteItemId())) {
                    $newItemQty = $quoteItem->getQty()-1;
                    if ($newItemQty > 0 && !$item->getProduct()->getIsVirtual()) {
                        $quoteItem->setQty($quoteItem->getQty()-1);
                    } else {
                        $this->getQuote()->removeItem($quoteItem->getId());
                    }
                }
                $this->save();
            }
        }
        return $this;
    }
    
   public function removeAddressItemFromAddress($addressId, $itemId)
    {
        $address = $this->getQuote()->getAddressById($addressId);
        /* @var $address Mage_Sales_Model_Quote_Address */
        if ($address) {
            $item = $address->getValidItemById($itemId);
            if ($item) {
                
                    $address->removeItem($item->getId());
                

                /**
                 * Require shiping rate recollect
                 */
                $address->setCollectShippingRates((boolean) $this->getCollectRatesFlag());

                if (count($address->getAllItems()) == 0) {
                    $address->isDeleted(true);
                }

                $this->save();
            }
        }
        return $this;
    }

    /**
     * Assign quote items to addresses and specify items qty
     *
     * array structure:
     * array(
     *      $quoteItemId => array(
     *          'qty'       => $qty,
     *          'address'   => $customerAddressId
     *      )
     * )
     *
     * @param array $info
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function setShippingItemsInformation($info)
    {
        if (is_array($info)) {
            $allQty = 0;
            $itemsInfo = array();
            foreach ($info as $itemData) {
                foreach ($itemData as $quoteItemId => $data) {
                    $allQty += $data['qty'];
                    $itemsInfo[$quoteItemId] = $data;
                }
            }

            $maxQty = (int)Mage::getStoreConfig('shipping/option/checkout_multiple_maximum_qty');
            if ($allQty > $maxQty) {
                Mage::throwException(Mage::helper('checkout')->__('Maximum qty allowed for Shipping to multiple addresses is %s', $maxQty));
            }
            $quote = $this->getQuote();
            $addresses  = $quote->getAllShippingAddresses();
            foreach ($addresses as $address) {
                $quote->removeAddress($address->getId());
            }

            foreach ($info as $itemData) {
                foreach ($itemData as $quoteItemId => $data) {
                    $this->_addShippingItem($quoteItemId, $data);
                }
            }

            /**
             * Delete all not virtual quote items which are not added to shipping address
             * MultishippingQty should be defined for each quote item when it processed with _addShippingItem
             */
            foreach ($quote->getAllItems() as $_item) {
                if (!$_item->getProduct()->getIsVirtual() &&
                    !$_item->getParentItem() &&
                    !$_item->getMultishippingQty()
                ) {
                    $_item->delete();
                }
            }

            if ($billingAddress = $quote->getBillingAddress()) {
                $quote->removeAddress($billingAddress->getId());
            }

            if ($customerDefaultBilling = $this->getCustomerDefaultBillingAddress()) {
                $quote->getBillingAddress()->importCustomerAddress($customerDefaultBilling);
            }

            foreach ($quote->getAllItems() as $_item) {
                if (!$_item->getProduct()->getIsVirtual()) {
                    continue;
                }

                if (isset($itemsInfo[$_item->getId()]['qty'])) {
                    if ($qty = (int)$itemsInfo[$_item->getId()]['qty']) {
                        $_item->setQty($qty);
                        $quote->getBillingAddress()->addItem($_item);
                    } else {
                        $_item->setQty(0);
                        $_item->delete();
                    }
                 }

            }

            $this->save();
            Mage::dispatchEvent('checkout_type_multishipping_set_shipping_items', array('quote'=>$quote));
        }
        return $this;
    }

    /**
     * Add quote item to specific shipping address based on customer address id
     *
     * @param int $quoteItemId
     * @param array $data array('qty'=>$qty, 'address'=>$customerAddressId)
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    protected function _addShippingItem($quoteItemId, $data)
    {
        $qty       = isset($data['qty']) ? (int) $data['qty'] : 1;
        //$qty       = $qty > 0 ? $qty : 1;
        $addressId = isset($data['address']) ? $data['address'] : false;
        $quoteItem = $this->getQuote()->getItemById($quoteItemId);

        if ($addressId && $quoteItem) {
            /**
             * Decrease quote item QTY if address item has QTY 0 and skip this item processing
             */
            if ($qty === 0) {
                $quoteItemQty = $quoteItem->getQty();
                if ($quoteItemQty > 0) {
                    $quoteItem->setQty($quoteItemQty-1);
                }
                return $this;
            }
            $quoteItem->setMultishippingQty((int)$quoteItem->getMultishippingQty()+$qty);
            $quoteItem->setQty($quoteItem->getMultishippingQty());
            $address = $this->getCustomer()->getAddressById($addressId);
            if ($address->getId()) {
                if (!$quoteAddress = $this->getQuote()->getShippingAddressByCustomerAddressId($address->getId())) {
                    $quoteAddress = Mage::getModel('sales/quote_address')->importCustomerAddress($address);
                    $this->getQuote()->addShippingAddress($quoteAddress);
                }

                $quoteAddress = $this->getQuote()->getShippingAddressByCustomerAddressId($address->getId());
                if ($quoteAddressItem = $quoteAddress->getItemByQuoteItemId($quoteItemId)) {
                    $quoteAddressItem->setQty((int)($quoteAddressItem->getQty()+$qty));
                } else {
                    $quoteAddress->addItem($quoteItem, $qty);
                }
                /**
                 * Require shiping rate recollect
                 */
                $quoteAddress->setCollectShippingRates((boolean) $this->getCollectRatesFlag());
            }
        }
        return $this;
    }

    /**
     * Reimport customer address info to quote shipping address
     *
     * @param int $addressId customer address id
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function updateQuoteCustomerShippingAddress($addressId)
    {
        if ($address = $this->getCustomer()->getAddressById($addressId)) {
            $this->getQuote()->getShippingAddressByCustomerAddressId($addressId)
                ->setCollectShippingRates(true)
                ->importCustomerAddress($address)
                ->collectTotals();
            $this->getQuote()->save();
        }
        return $this;
    }

    /**
     * Reimport customer billing address to quote
     *
     * @param int $addressId customer address id
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function setQuoteCustomerBillingAddress($addressId)
    {
        if ($address = $this->getCustomer()->getAddressById($addressId)) {
            $this->getQuote()->getBillingAddress($addressId)
                ->importCustomerAddress($address)
                ->collectTotals();
            $this->getQuote()->collectTotals()->save();
        }
        return $this;
    }

    /**
     * Assign shipping methods to addresses
     *
     * @param  $method
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function setShippingMethods()
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

    /**
     * Set payment method info to quote payment
     *
     * @param array $payment
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function setPaymentMethod()
    {
        
        $quote = $this->getQuote();
        $quote->getPayment()->importData(array('method'=>$this->getPaymentMethod()));
        // shipping totals may be affected by payment method
        if (!$quote->isVirtual() && $quote->getShippingAddress()) {
            $quote->getShippingAddress()->setCollectShippingRates(true);
            $quote->setTotalsCollectedFlag(false)->collectTotals();
        }
        $quote->save();
        return $this;
    }
    
    
    public function setVergabenummern($value = array())
    {
    	$this->_vergabenummern = $value;
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
            
            $los = Mage::getModel('framecontract/los')->loadByProductId($item->getProduct()->getId());
            $orderItem->setLosId($los->getLosId());
            
            if ($item->getParentItem()) {
                $orderItem->setParentItem($order->getItemByQuoteItemId($item->getParentItem()->getId()));
            }
            
            $order->addItem($orderItem);
        }
        if(isset($this->_vergabenummern[$address->getId()])){
        	$order->setVergabenummer($this->_vergabenummern[$address->getId()]);
        }
        
        if(Mage::helper('sidcheckout')->isModuleEnabled('Sid_Haushalt')){
        	$lg = Mage::getModel('sidhaushalt/lg04Pool');
        	$min = Mage::getConfig()->getNode('sid_haushaltsysteme/lg04/params/increment_pool/min')->__toString();
        	$max = Mage::getConfig()->getNode('sid_haushaltsysteme/lg04/params/increment_pool/max')->__toString();
        	$order->setData('u4_increment_id', $lg->getNextIncrementId($min,$max));
        }
        
        $order->setFramecontract($los->getFramecontractContractId());

        return $order;
    }

    /**
     * Validate quote data
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    protected function _validate()
    {
        $helper = Mage::helper('sidcheckout');
        $quote = $this->getQuote();
       
        /** @var $paymentMethod Mage_Payment_Model_Method_Abstract */
        $paymentMethod = $quote->getPayment()->getMethodInstance();
        if (!empty($paymentMethod) && !$paymentMethod->isAvailable($quote)) {
            Mage::throwException($helper->__('Please specify payment method.'));
        }

        $addresses = $quote->getAllShippingAddresses();
        foreach ($addresses as $address) {
            $addressValidation = $address->validate();
            if ($addressValidation !== true) {
                Mage::throwException($helper->__('Please check shipping addresses information.'));
            }
            $address->setShippingMethod($this->getShippingMethod())->save();
            $method= $address->getShippingMethod();
            $rate  = $address->getShippingRateByCode($method);
            if (!$method || !$rate) {
                Mage::throwException($helper->__('Please specify shipping methods for all addresses.'));
            }
        }
        $addressValidation = $quote->getBillingAddress()->validate();
        if ($addressValidation !== true) {
            Mage::throwException($helper->__('Please check billing address information.'));
        }
        return $this;
    }

    /**
     * 
     * die Produkte pro Adresse nochmals aufteilen falls unterschiedliche Rahmenverträge 
     */
    public function splitFrameContracts()  
    {
    	//return $this;
        $shippingAddresses = $this->getQuote()->getAllShippingAddresses();
        foreach($shippingAddresses as $address)
        {
        	$items = $address->getAllItems();
        	$n = 0;
        	foreach ($items as $item)
        	{
        	 	if ($item->getParentItemId()) {
                    continue;
                }
                //Rahmenvertrag finden
                $los = Mage::getModel('framecontract/los')->loadByProductId($item->getProduct()->getId());
        		$fcid = $los->getFramecontractContractId();
        		//initialisieren
        		if($n == 0) $address->setFrameContractId($fcid);
        		$n++;
        		
        		if($address->getFrameContractId() != $fcid)
        		{
        			$adr = $this->getFrameContractShippingAddress($fcid,$address->getCustomerAddressId());
        		    //falls neue Adresse Item aus alter löschen    			
        			if($address->getId() != $adr->getId())
        			{
	        			$address->removeItem($item->getId())->save();
	        			$item->delete()->save();
	        			$address->getItemsCollection()
	        				->removeItemByKey($item->getId())
	        				->save();
	        			$address->unsetData('cached_items_nominal')
        						->unsetData('cached_items_nonominal')
        						->unsetData('cached_items_all')
        						->save();
	        			
	        			
	        			if($item->getQuoteItem()){
	        				$adr->addItem($item->getQuoteItem(),$item->getQty())->save();
	        			}
        			}

        		}
        		
        	}
        }
        
        
        
        $shippingAddresses = $this->getQuote()->getAllShippingAddresses();
        foreach($shippingAddresses as $address)
        {
        	$address->setGrandTotal(0)
        		->setBaseGrandTotal(0)
        		->setShippingMethod($this->getShippingMethod())
        		->unsetData('cached_items_nominal')
        		->unsetData('cached_items_nonominal')
        		->unsetData('cached_items_all')
        		->collectTotals()
        		->save();
        }
        $this->getQuote()->collectTotals();
        return $this;
    }
    
    private function getFrameContractShippingAddress($fcid,$CustomerAddressId)
    {
    	$shippingAddresses = $this->getQuote()->getAllShippingAddresses();
        foreach($shippingAddresses as $address)
        {
        	if( ($address->getCustomerAddressId() == $CustomerAddressId) && ($address->getFrameContractId() == $fcid) )
        	{
        		return $address;
        	}
        }
    	$address = $this->getNewShippingAddress($CustomerAddressId);
    	$this->getQuote()->setIsMultiShipping(true);
    	//die Adresse darf noch nicht gespeichert sein
    	$this->getQuote()->addShippingAddress($address)->save();
    	$address->setShippingMethod($this->getShippingMethod())
    		->setFrameContractId($fcid)
    		->setCollectShippingRates(true)
    		->save();
    
    	//$address->unsetData('address_id')->save();
    	return $address;
    }
    
    /**
     * Create orders per each quote address
     *
     * @return Mage_Checkout_Model_Type_Multishipping
     */
    public function createOrders()
    {
        $orderIds = array();
        $this->_validate();
        
        $shippingAddresses = $this->getQuote()->getAllShippingAddresses();
        $orders = array();

        if ($this->getQuote()->hasVirtualItems()) {
            $shippingAddresses[] = $this->getQuote()->getBillingAddress();
        }

        try {
            foreach ($shippingAddresses as $address) {
                $order = $this->_prepareOrder($address);

                $orders[] = $order;
                Mage::dispatchEvent(
                    'checkout_type_multishipping_create_orders_single',
                    array('order'=>$order, 'address'=>$address)
                );
            }

            foreach ($orders as $order) {
                $order->place();
                $order->save();
                if($order->getContract() == null){
                    if($order->getFramecontract()) {
                        $order->setContract(Mage::getModel('framecontract/contract')->load($order->getFramecontract()));
                    }
                }
                if ($order->getCanSendNewEmailFlag()){
                    $order->sendNewOrderEmail();
                }
                $orderIds[$order->getId()] = $order->getIncrementId();
            }

            Mage::getSingleton('core/session')->setOrderIds($orderIds);
            Mage::getSingleton('checkout/session')->setLastQuoteId($this->getQuote()->getId());

            $this->getQuote()
                ->setIsActive(false)
                ->save();

            Mage::dispatchEvent('checkout_submit_all_after', array('orders' => $orders, 'quote' => $this->getQuote()));

            return $this;
        } catch (Exception $e) {
            Mage::dispatchEvent('checkout_multishipping_refund_all', array('orders' => $orders));
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
