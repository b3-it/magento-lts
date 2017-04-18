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
	
	
	public function xonSalesOrderSaveAfter($observer) {
		/* @var $order Mage_Sales_Model_Order */
		$order = $observer->getOrder();
	
	
		if (!$order || $order->isEmpty()) {
			return;
		}
	
	
		$state = $order->getState();
		if(($state != Mage_Sales_Model_Order::STATE_COMPLETE)
				&& ($state != Mage_Sales_Model_Order::STATE_PROCESSING)
				&& ($state != Mage_Sales_Model_Order::STATE_CANCELED)
				&& ($state != Mage_Sales_Model_Order::STATE_CLOSED))
		{
			return;
		}
	
	
		//nur bei Status änderung weitermachen
		$origState = 'dummy';
		if(count($order->getOrigData()) > 0)
		{
			$orig = $order->getOrigData();
			$origState = $orig['state'];
		}
	
	
		$this->setLog('onSalesOrderSaveAfter: ID=' .$order->getId(). ', state='. $state .', origState='.$origState);
	
		//falls keine Änderung -> keine Aktion
		if($origState == $state)
		{
			return;
		}
	
		//hier den Fall Stornierung abhandeln
		if((($origState != Mage_Sales_Model_Order::STATE_CANCELED)|| ($origState != Mage_Sales_Model_Order::STATE_CLOSED)) &&
				(($state == Mage_Sales_Model_Order::STATE_CANCELED)  || ($state == Mage_Sales_Model_Order::STATE_CLOSED)))
		{
	
			//$this->_cancelOrderItems($order->getAllItems());
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
	
		
	
	
	
		return $this;
	}
	

}