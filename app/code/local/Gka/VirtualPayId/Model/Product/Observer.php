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
		
// 		if (!$orderitem->getId()) {
// 			//order not saved in the database
// 			return $this;
// 		}
// 		$product = $orderitem->getProduct();
	
// 		if (!$product) {
// 			$product = Mage::getModel('catalog/product')
// 			->setStoreId($order->getStoreId())
// 			->load($orderitem->getProductId());
// 		} 
		
// 		if ($product && $product->getTypeId() != Gka_VirtualPayId_Model_Product_Type_Virtualpayid::TYPE_VIRTUAL_PAYID) {
// 			return $this;
// 		}
	
		
// 		$br = $orderitem->getBuyRequest();
		
// 		Mage::getModel('virtualpayid/payid')
// 			->setOrderItemId($orderitem->getId())
// 			->setKassenzeichen($br->getPayId())
// 			->save();
		
	
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
			break;
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
		$product = $observer->getProduct();
		/** @var $quote Mage_Sales_Model_Quote */
		$quote = $quoteItem->getQuote();
		if ($product && $product->getTypeId() != Gka_VirtualPayId_Model_Product_Type_Virtualpayid::TYPE_VIRTUAL_PAYID) {
			return $this;
		}
		
		try{
			$items = $quote->getAllVisibleItems();
			//$items[] = new Varien_Object(array('product'=>$product,'qty'=>1));
			$this->testCart($items);
			
		}
		catch(Exception $ex){
			$quote->removeItem($quoteItem->getId());
			Mage::getSingleton('customer/session')->addError($ex->getMessage());
		}
		
		$quote->setExternesKassenzeichen(1);
		
		$br = $quoteItem->getBuyRequest();
		$specialPrice = (float)($br->getAmount());

		
		if ($specialPrice > 0) {
				$quoteItem->setCustomPrice($specialPrice);
				$quoteItem->setOriginalCustomPrice($specialPrice);
				$quoteItem->getProduct()->setIsSuperMode(true);
		}else{
			//throw new Exception('Preis darf nicht null sein!');
		}
	}

}