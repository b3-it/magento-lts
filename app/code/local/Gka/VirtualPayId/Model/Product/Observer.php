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
	
	
	/**
	 * Wenn Produkt in Quote gesetzt wird
	 *
	 * @param Varien_Event_Observer $observer Observer
	 *
	 * @return Gka_VirtualPayId_Model_Product_Observer
	 */
	public function onSalesQuoteItemSetProduct($observer) {
		$orderItem = $observer->getQuoteItem();
		$product = $observer->getProduct();
		if ($product && $product->getTypeId() != Gka_VirtualPayId_Model_Product_Type_Virtualpayid::TYPE_VIRTUAL_PAYID) {
			return $this;
		}
	
		$br = $orderItem->getBuyRequest();
		$specialPrice = (float)($br->getAmount());

		
		if ($specialPrice > 0) {
				$orderItem->setCustomPrice($specialPrice);
				$orderItem->setOriginalCustomPrice($specialPrice);
				$orderItem->getProduct()->setIsSuperMode(true);
		}else{
			//throw new Exception('Preis darf nicht null sein!');
		}
	}

}