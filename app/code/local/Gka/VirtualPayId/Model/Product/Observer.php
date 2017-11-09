<?php
class Gka_VirtualPayId_Model_Product_Observer extends Varien_Object
{
	
	

	public function prepareProductSave($observer) {
		$request = $observer->getEvent()->getRequest();
		$product = $observer->getEvent()->getProduct();
	
		
		return $this;
	}
	
	
	public function onSalesOrderSaveAfter($observer) {
		/* @var $order Mage_Sales_Model_Order */
		$order = $observer->getOrder();
	
	
		if (!$order || $order->isEmpty()) {
			return;
		}
	
		foreach($order->getAllItems() as $orderitem)
		{
			/* @var $orderitem Mage_Sales_Model_Order_Item */
			if(count($orderitem->getChildrenItems()) > 0){
				continue;
			}
			$this->processOrderItem($orderitem, $order);
		}
	
	
	
	}
	
	public function processOrderItem($orderitem, $order)
	{
		return $this;
	}
	
	public function onCheckoutCartUpdateItemsAfter($observer)
	{
		$cart = $observer['cart'];
		$quote = $cart->getQuote();
		$items = $quote->getAllVisibleItems();
		$this->testCart($items);
	}
	
	public function onQuoteMerge($observer)
	{
		try
		{
			$quote = $observer->getData('quote');
			$this->testCart($quote->getAllVisibleItems());
				
		}
		catch(Exception $ex){
			
			Mage::getSingleton('customer/session')->addError($ex->getMessage());
		}
	}
	
	public function onSalesQuoteAddItem($observer) {
		/* @var $item Mage_Sales_Model_Quote_Item */
		$item = $observer->getQuoteItem();
		if (!$item) {
			return;
		}
	
		$quote = $item->getQuote();
		$this->testCart($quote->getAllVisibleItems());
	}
	
	public function testCart($items)
	{	
		$_virtualpayidCount = 0;
	
		foreach ($items as $item) 
		{
			if ($item->getParentItem()) {
				continue;
			}
			$product = $item->getProduct();
			if ($product && $product->getTypeId() == Gka_VirtualPayId_Model_Product_Type_Virtualpayid::TYPE_VIRTUAL_PAYID) {
				$_virtualpayidCount++;
				if($item->getQty() > 1)
				{
					Mage::throwException(Mage::helper('virtualpayid')->__('Maximum Quantity is excceded.'));
					break;
				}
			}
		}
		
		if(($_virtualpayidCount > 0) && (count($items) > 1)){
			Mage::throwException(Mage::helper('virtualpayid')->__('Produkte für externe Kassenzeichen dürfen nur einzeln abgerechnent werden.'));
			
		}
	}
	
	
	
	
	/**
	 * Wenn Produkt in Quote gesetzt wird
	 *
	 * @param Varien_Event_Observer $observer Observer
	 *
	 * @return Gka_VirtualPayId_Model_Product_Observer
	 */
	public function onSalesQuoteItemSetProduct($observer) {
		$quoteItem = $observer->getQuoteItem();
		/** @var $product Mage_Catalog_Model_Product */
		$product = $observer->getProduct();
		/** @var $quote Mage_Sales_Model_Quote */
		$quote = $quoteItem->getQuote();
		if ($product && $product->getTypeId() != Gka_VirtualPayId_Model_Product_Type_Virtualpayid::TYPE_VIRTUAL_PAYID) {
			return $this;
		}
		
		try {
			$items = $quote->getAllVisibleItems();
			$this->testCart($items);
			
		} catch(Exception $ex){
			$quote->removeItem($quoteItem->getId());
			Mage::getSingleton('customer/session')->addError($ex->getMessage());
		}

        /**
         * @var Mage_Sales_Model_Quote_Item_Option $payId Kassenzeichen
         */
		$payId = $product->getCustomOption('pay_id');
		if (is_null($payId) || $payId->isEmpty() || !$payId->getValue()) {
            $quote->removeItem($quoteItem->getId());
		    Mage::throwException(Mage::helper('virtualpayid')->__('No external Kassenzeichen available!'));
        }
        $payId = $payId->getValue();
        $payClient = $product->getCustomOption('pay_client');
		if (is_null($payClient) || $payClient->isEmpty() || !$payClient->getValue()) {
            $quote->removeItem($quoteItem->getId());
            Mage::throwException(Mage::helper('virtualpayid')->__('No external Bewirtschafter available!'));
        }
        $payClient = $payClient->getValue();

        /*
         * Format: Bewirtschafter/Kassenzeichen
         */
		$quote->setExternesKassenzeichen(sprintf('%s/%s', $payClient, $payId));
		
		$br = $quoteItem->getBuyRequest();
		$specialPrice = (float)($br->getAmount());

		
		if ($specialPrice > 0) {
				$quoteItem->setCustomPrice($specialPrice);
				$quoteItem->setOriginalCustomPrice($specialPrice);
				$quoteItem->getProduct()->setIsSuperMode(true);
		} else {
			//throw new Exception('Preis darf nicht null sein!');
		}
	}

}