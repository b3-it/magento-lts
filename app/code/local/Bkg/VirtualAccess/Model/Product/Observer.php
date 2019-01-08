<?php
class Bkg_VirtualAccess_Model_Product_Observer extends Varien_Object
{
	private $_station = null;


	/**
	 * Daten für Configurable Virtual für spätere Bearbeitung setzen
	 *
	 * @param Varien_Object $observer
	 *
	 * @return void
	 */
	public function prepareProductSave($observer) {
		$request = $observer->getEvent()->getRequest();
		$product = $observer->getEvent()->getProduct();

		if ($virtualaccess = $request->getPost('virtualaccess')) {
			$product->setConfigvirtualData($virtualaccess);
		}


	}

	public function prepareProductEdit($observer) {
		/* @var $product Mage_Catalog_Model_Product */
		$product = $observer->getProduct();
		if (!$product || $product->getTypeId() != Bkg_VirtualAccess_Model_Product_Type::TYPE_CODE) {
			return;
		}

		$product->getTypeInstance()->limitMaxSaleQty($product);
	}





	public function onSalesOrderSaveAfter($observer) {
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

			$this->_cancelOrderItems($order->getAllItems());
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
		} else {
			$product = Mage::getModel('catalog/product')->load($product->getId());
		}
		if ($product && $product->getTypeId() != Bkg_VirtualAccess_Model_Product_Type::TYPE_CODE) {
			return $this;
		}

		$this->savePurchased($orderitem,$order, $product);




		return $this;
	}

	/**
	 * Stornierung von CVP Produkten - Statusänderung in ICD
	 * @param Mage_Sales_Model_Order_Item $orderItems
	 */
	public function _cancelOrderItems($orderItems)
	{
		if(count($orderItems) == 0) { return; }
		foreach($orderItems as $orderItem)
		{
			/* @var $orderitem Mage_Sales_Model_Order_Item */
			if(count($orderItem->getChildrenItems()) > 0){
				continue;
			}
			if($orderItem->getProductType() != Bkg_VirtualAccess_Model_Product_Type::TYPE_CODE){
				continue;
			}

			//Zugang via ICD schließen
			$purchasedItem = Mage::getModel('dwd_icd/orderitem')->load($orderItem->getId(),'order_item_id');
			if($purchasedItem->getId() > 0)
			{
				//
				if(($purchasedItem->getStatus() == Dwd_Icd_Model_OrderStatus::ORDERSTATUS_ACTIVE)&&
					($purchasedItem->getSyncStatus() == Dwd_Icd_Model_Syncstatus::SYNCSTATUS_SUCCESS))
				{
					$purchasedItem
					->setStatus(Dwd_Icd_Model_OrderStatus::ORDERSTATUS_DISABLED)
					->setSyncStatus(Dwd_Icd_Model_Syncstatus::SYNCSTATUS_PENDING)
					->save();
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtualaccess')->__('ICD has been informed removing credetials!'));
				}
				else
				{
					
					Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('virtualaccess')->__('Item %s could not canceld within ICD (Id: %s) Status %s Sync %s.',
							$orderItem->getName(), 
							$purchasedItem->getId(),
							Dwd_Icd_Model_OrderStatus::getLabel($purchasedItem->getStatus()),
							Dwd_Icd_Model_OrderStatus::getLabel($purchasedItem->getSyncStatus())
									));
				}
			}


			if($orderItem->getPeriodType() == Dwd_Periode_Model_Periode_Type::PERIOD_DURATION_ABO)
			{
				$abo = Mage::getModel('dwd_abo/abo')->load($orderItem->getId(),'current_orderitem_id');
				if($abo->getId() > 0)
				{
					$abo->setRenewalStatus(Dwd_Abo_Model_Renewalstatus::STATUS_PAUSE)
						->setStatus(Dwd_Abo_Model_Status::STATUS_DELETE)
						->save();
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('virtualaccess')->__('Subscription has ben closed!'));
					$firstOrderID = $abo->getFirstOrderId();
					if($firstOrderID)
					{
						$collection = Mage::getModel('dwd_abo/abo')->getCollection();
						$collection->getSelect()
							->where('first_order_id = ?', intval($firstOrderID))
							->where('current_orderitem_id > ? ', $orderItem->getId());

						if(count($collection->getItems()) > 0 )
						{
							foreach($collection->getItems() as $item){
								//Der Zugang wird zum Laufzeitende des Abonnements (09.05.2016) automatisch entfernt (#Angabe des Produkts#)“).
								Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('virtualaccess')->__("Der Zugang wird zum Laufzeitende des Abonnements (%s) automatisch entfernt (%s)."
										,Mage::app()->getLocale()->date($item->getStopDate(), null, null, true),
										$orderItem->getName()));
							}
						}
					}
				}

			}
		}
	}

    public function onBeforeSaveOrderItem($observer)
    {
    	return $this;

    }


    protected function savePurchased($orderItem, $order, $product)
    {
    	/** @var $purchased Bkg_VirtualAccess_Model_Purchased */
  			$purchased = Mage::getModel('virtualaccess/purchased')->load($order->getId(),'order_id');
	        if($purchased->getId() == 0)
	        {
	        	$purchased 	->setOrderId($order->getId())
	        				->setOrderIncrementId($order->getIncrementId())
	        				->setOrderItemId($orderItem->getId())
	        				->setProductSku($orderItem->getProduct()->getSku())
	        				->setProductCode($orderItem->getProduct()->getProductCode())
	        				->setBaseUrl($orderItem->getProduct()->getVirtualaccessBaseUrl())
	        				->setCreatedAt(now())
							->setUpdatedAt(now())
							->setCustomerId($order->getCustomerId())
							->setStatus(Bkg_VirtualAccess_Model_Service_AccountStatus::ACCOUNTSTATUS_NEW)
							->setSyncStatus(Bkg_VirtualAccess_Model_Service_Syncstatus::SYNCSTATUS_PENDING)
							->save();
							;
	        }


    }

  


    public function getStoreId($item = null)
    {
    	
    	if($item instanceof Mage_Sales_Model_Quote_Item){
    		return $item->getQuote()->getStoreId();
    	}
    	
    	if($item instanceof Mage_Sales_Model_Order_Item){
    		return $item->getOrder()->getStoreId();
    	}
    	
    	return Mage::app()->getStore()->getId();
    }



}