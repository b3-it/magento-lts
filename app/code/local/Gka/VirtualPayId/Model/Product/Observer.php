<?php
class Gka_VirtualPayId_Model_Product_Observer extends Varien_Object
{
	
	
	/**
	 * TANs für Tuc voucher importieren
	 *
	 * @param Varien_Object $observer
	 * 
	 * @return void
	 */
	public function prepareProductSave($observer) {
		$request = $observer->getEvent()->getRequest();
		$product = $observer->getEvent()->getProduct();
		$tans = array();
		
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
		if (!$orderitem->getId()) {
			//order not saved in the database
			return $this;
		}
		$product = $orderitem->getProduct();
	
		if (!$product) {
			$product = Mage::getModel('catalog/product')
			->setStoreId($order->getStoreId())
			->load($orderitem->getProductId());
		} 
		
		if ($product && $product->getTypeId() != Gka_VirtualPayId_Model_Product_Type_Virtualpayid::TYPE_VIRTUAL_PAYID) {
			return $this;
		}
	
		
		$br = $orderitem->getBuyRequest();
		
		Mage::getModel('virtualpayid/payid')
			->setOrderItemId($orderitem->getId())
			->setKassenzeichen($br->getPayId())
			->save();
		
	
		return $this;
	}
	

}