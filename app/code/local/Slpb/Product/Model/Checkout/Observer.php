<?php

class Slpb_Product_Model_Checkout_Observer extends Mage_Core_Model_Abstract 
{

	private function _redirect($url)
	{
		$url = Mage::getUrl($url);
		$app = Mage::app()->getResponse()
			->setRedirect($url)
			->sendResponse();
		die();
	}
	
	public function onMPCheckoutBillingAddressSet($observer)
	{
		$quote = $observer->getQuote();
		$adr = $quote->getShippingAddress();
		if($adr->getSameAsBilling()){
			$this->testCart($quote->getAllVisibleItems(),$adr);
		}
		try
		{
			$this->testPeriod($quote->getCustomerId()); 
		}
		catch(Exception $ex){
			$sess = Mage::getSingleton('core/session');
			$sess->addError($ex->getMessage());
			/*
			$messages = $sess->getMessages();
			$quote->addMessage($ex->getMessage());
			Mage::getSingleton('core/message')->error('TEST');
			//if($messages->getLastAddedMessage()->getCode() != 	$ex->getMessage())
			{
				$sess->addError($ex->getMessage());
			}
			*/
			$this->_redirect('checkout/cart');
			
		}
		
	}
	
	public function onMPCheckoutShippingAddressSet($observer)
	{
		$quote = $observer->getQuote();
		$adr = $quote->getShippingAddress();
		$this->testCart($quote->getAllVisibleItems(),$adr);
		
	}
	
	public function onQuoteMerge($observer)
	{
		//$quote =  Mage::getSingleton('checkout/session')->getQuote();
		try
		{
			$quote = $observer->getData('quote');
			$adr = $quote->getCustomer()->getShippingAddress();
			$this->testCart($quote->getAllVisibleItems(),$adr);
			
		}
		catch(Exception $ex){
			//$quote->addMessage($ex->getMessage());
			//Mage::getSingleton('core/message')->error('TEST');
			Mage::getSingleton('customer/session')->addError($ex->getMessage());
		}
		
		
	}
	
	public function onCheckoutEntryBefore($observer)
	{
		try {
			$quote = $observer['quote'];

            if ($quote->getRequestAction() == 'successview') {
                return $this;
            }

			$adr = $this->getAddress($quote);
			$this->testCart($quote->getAllVisibleItems(),$adr);
			$this->testPeriod($quote->getCustomerId()); 
		}
		catch(Exception $ex){
			//$quote->addMessage($ex->getMessage());
			//Mage::getSingleton('core/message')->error('TEST');
			$sess = Mage::getSingleton('core/session');
			$messages = $sess->getMessages();
			
			//if($messages->getLastAddedMessage()->getCode() != 	$ex->getMessage())
			{
				$sess->addError($ex->getMessage());
			}
			
			$this->_redirect('checkout/cart');
		}
	}
	
	
	private function getAddress($quote)
	{
		$adr = $quote->getShippingAddress();
		if($adr->getCustomerAddressId()== null){
				$adr = $quote->getCustomer()->getDefaultShippingAddress();
			}
		return $adr;
	}
	
	
	public function onCheckoutCartUpdateItemsBefore($observer)
	{
		$cart = $observer['cart'];
		$quote = $cart->getQuote();
		$adr = $this->getAddress($quote);
		$items = $quote->getAllVisibleItems();
		$this->testCart($items,$adr);
	}
	
	public function onCheckoutCartProductAddBefore($observer)
	{
		$cart = $observer['cart'];
		$request = $observer['request'];
		$product = $observer['product']; 
		$quote = $cart->getQuote();
	
		$adr = $this->getAddress($quote);
		
		$item = new Varien_Object(array('qty'=>$request->getQty()));
		$item->setProduct($product);
		$items = $quote->getAllVisibleItems();
		$found = false;
		foreach($items as $i)
		{
			if($i->getProduct()->getId() == $product->getId())
			{
				$i->setQty($i->getQty()+$request->getQty());
				$found = true;
				break;
			}
		}
		if(!$found) {$items[] = $item;}
		$this->testCart($items,$adr);
	}
	
	
	public function testCart($items,$address)
	{
		$star = 0;
		$count = 0;
		
		$max_qty = intval(Mage::getStoreConfig('checkout/cart/slpb_max_qty', $this->getStore()));
		
		foreach ($items as $item) {
	            if ($item->getParentItem()) {
	                continue;
	            }
	           	$p = $item->getProduct();
	            if($p->getSlpbLimit())
	            {
		            if($item->getQty() > $max_qty)
		            {
		            	Mage::throwException(Mage::helper('slpbproduct')->__('Maximum Quantity is excceded.'));
		            	break;
		            }

	            	if ($p->getSternchen())
	            	{
	            		$star += $p->getSternchen() * $item->getQty();
	            	}
	            	else 
	            	{
	            		$count += $item->getQty();
	            	}

	            	
	            }
	     }    
		$maxstar = intval(Mage::getStoreConfig('checkout/cart/slpb_stars', $this->getStore()));
        $maxcount = intval(Mage::getStoreConfig('checkout/cart/slpb_count', $this->getStore()));
        if($star > $maxstar ){
            Mage::throwException(Mage::helper('slpbproduct')->__('You have too much stars at your cart.'));
            }
            
        if($count > $maxcount ){
            Mage::throwException(Mage::helper('slpbproduct')->__('You have too much limited items at your cart.'));
            }
        
        if((($count > 0) || ($star > 0))&&($address != null)){
        	if(!Mage::helper('slpbproduct')->isSaxony($address->getPostcode())
					|| ($address->getCountryId()!= 'DE') ){
					Mage::throwException(Mage::helper('slpbproduct')->__('Your Cart contains some Items that for saxony citizen only.'));
				}
        }
        
       
	}
	
	public function testPeriod($customer_id)
	{
		
		if($customer_id==null)
		{
			return 0;
		}
		$qty = 0;
		$sql = "";
		try
		{
			$von = Mage::getStoreConfig('general/slpb/period_start', $this->getStore());
			$bis = Mage::getStoreConfig('general/slpb/period_stop', $this->getStore());
			if(Zend_Date::isDate($von,'yyyy-mm-dd') && Zend_date::isDate($bis,'yyyy-mm-dd')){
				$status = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('order','status');
				$state = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('order','state');
				
				$sale = Mage::getModel('sales/order')->getCollection();
				$sale->getSelect()
					->where("created_at >='".$von."'")
					->where("created_at <='".$bis."'")
					->where('customer_id ='.$customer_id)
					//->join(array('t1'=>'sales_order_varchar'),'t1.entity_id = e.entity_id AND t1.attribute_id='.$status,array())
					//->join(array('t2'=>'sales_order_varchar'),'t2.entity_id = e.entity_id AND t2.attribute_id='.$state,array())
					//->where("((status = 'canceled') OR NOT ((state = 'closed') AND (status = 'special_canceled')))");
					->where("((status = 'complete') OR (status = 'processing') OR (status = 'pending'))");
					
				
					
//die($sale->getSelect()->__toString());	
				$items = $sale->getItems();			
				$qty = count($items);
			}	
			else
			{
				Mage::log("testPeriod:: Date Error ".$von. '-'. $bis, Zend_Log::ALERT,Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
			}
		}
		catch(Exception $ex)
		{
			Mage::log("testPeriod:: SQLError ".$ex->getMessage() . ': '. $sql
    			, Zend_Log::ALERT
    			, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
		}
		
		if($qty >= intval(Mage::getStoreConfig('checkout/cart/orders_per_period', $this->getStore()))){
			Mage::throwException(Mage::helper('slpbproduct')->__('There are too much orders at this period.'));
		}
		return $qty;
	
	}

	
}