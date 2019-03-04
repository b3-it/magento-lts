<?php

class Egovs_Extstock_Model_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * Wird am Ende eines Verkaufsprozesses aufgerufen und verarbeitet die Abbuchung in der
	 * erweiterten Lagerverwaltung.
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return $this
	 */
	public function onCheckoutTypeOnepageSaveOrderAfter($observer) {
		/*
		Mage::log("extstock::checkout_type_onepage_save_order_after raised"
			, Zend_Log::DEBUG
			, Egovs_Extstock_Helper_Data::LOG_FILE);
		*/
		$order = $observer->getData('order');
		
		if (!($order instanceof Mage_Sales_Model_Order)) {
			return;
		}

		foreach ($order->getAllItems() as $item) {
			if (!($item instanceof Mage_Sales_Model_Order_Item)) {
				continue;
			}

			try { 
				$product_id = $item->getData("product_id");
				$quantity = $item->getData("qty_ordered");
				$order_id = $item->getOrderId();
				
				//TODO: Was passiert wenn mehr bestellt sind als geliefert werden können?
				$toShip = $item->getQtyToShip();			
				
				if (!Egovs_Extstock_Helper_Data::checkForUsableProductType($item)
					|| !Egovs_Extstock_Helper_Data::isManagedStock($product_id)
				) {
					continue;
				}
	
				Mage::getModel('extstock/extstock')->decreaseQuantity($product_id, $quantity, $order_id);
			} catch (Exception $e) {
				Mage::log($e->getMessage(), Zend_Log::ALERT, Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
			}				
		}
	}
	
	
	
	protected function _getItemData()
	{
		$data = Mage::app()->getRequest()->getParam('creditmemo');
		if (!$data) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		}
	
		if (isset($data['items'])) {
			$qtys = $data['items'];
		} else {
			$qtys = array();
		}
		return $qtys;
	}
	
	/**
	 * Wird ausgeführt wenn eine Bestellung storniert wird.
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return $this
	 */
	public function onSalesOrderItemCancel($observer) {
		Mage::log("extstock::sales_order_item_cancel event raised", Zend_Log::DEBUG, Egovs_Extstock_Helper_Data::LOG_FILE);
		
		if (!$observer) {
			return $this;
		}
		
		if ($observer->getEvent()->getName() != "sales_order_item_cancel") {
			return $this;
		}
		
		$orderItem = $observer->getEvent()->getItem();
		
		$this->_salesOrderItemCancelRefund($orderItem);
		
		return $this;
	}
	
	/**
	 * Bucht eine Menge wieder zurück ins Lager
	 * 
	 * @param Mage_Sales_Model_Order_Item $orderItem OrderItem
	 * @param bool 					      $isRefund  Ist es eine Gutschrift?
	 * 
	 * @return $this
	 */
	protected function _salesOrderItemCancelRefund($orderItem, $isRefund = false) {
		if (!$orderItem || !($orderItem instanceof Mage_Sales_Model_Order_Item)) {
			return $this;
		}
		
		//Kindelemente von Configurable Products werden separat storniert!
		if (!Egovs_Extstock_Helper_Data::checkForUsableProductType($orderItem)) {
			Mage::log("extstock::Item [ID:".$orderItem->getId().";Product ID:".$orderItem->getProductID()."] is not useable with extended store.",
				Zend_Log::NOTICE,
				Egovs_Extstock_Helper_Data::LOG_FILE);
			return $this;
		}
		
		if (!Egovs_Extstock_Helper_Data::isManagedStock($orderItem->getProductId())) {
			return $this;
		}
		
		$model = Mage::getModel("extstock/salesorder");
		
		if (!$model) {
			Mage::throwException("Can't get 'extstock/salesorder' model!");
		}
		if ($isRefund) {
			$model->salesOrderItemRefund($orderItem);
		} else {
			$model->salesOrderItemCancel($orderItem);
		}
		
		return $this;
	}
	
	/**
     * Back refunded item qty to stock
     *
     * @param Varien_Event_Observer $observer Observer
     * 
     * @return  $this
     */
    public function refundOrderItem($observer)
    {
    	Mage::log("extstock::sales_creditmemo_item_save_after event raised", Zend_Log::DEBUG, Egovs_Extstock_Helper_Data::LOG_FILE);
        
    	$formData = $this->_getItemData();
    	$backToStock = array();
    	foreach ($formData as $orderItemId =>$itemData) {
    		
    		if (isset($itemData['back_to_stock'])) {
    			$backToStock[$orderItemId] = true;
    		}
    	}
    	
    	
    	$item = $observer->getEvent()->getCreditmemoItem();
        if ($item->getId() && $item->getBackToStock() && ($productId = $item->getProductId()) && ($qty = $item->getQty())) {
        	$orderItem = $item->getOrderItem();
        	if (isset($backToStock[$orderItem->getId()]))
        	{
				$this->_salesOrderItemCancelRefund($orderItem, true);
        	}
        }
        return $this;
    }

	/**
	 * 
	 * @param Varien_Event_Observer $observer
	 * @return $this
	 */
    /*
	public function onPrepareTabLayout($observer)
	{
		if($observer == null) return;

		$form = $observer->getData('form');
		$product = $observer->getData('product');

		if(($form == null) || ($product == null)) return;
		Mage::getSingleton('adminhtml/session')->setData('extstockmode','product');
		Mage::getSingleton('adminhtml/session')->setData('extstockproduct',$product->getEntityId()); 
		if (Egovs_Extstock_Helper_Data::checkForUsableProductType($product->getTypeId()))
		{
			$form->addTab('extinventory', array(
                'label'     => Mage::helper('catalog')->__('Extended Inventory'),
                'content'   => $form->getLayout()->createBlock('extstock/adminhtml_catalog_product_edit_tab_extstock','',array('product'=>$product))
			->toHtml(),
			));
		}
		
		return $this;
	}
*/
	/**
	 * Wird aufgerufen, nach dem ein Produkt gespeichert wurde.
	 * Falls vorhanden, werden Daten in die erweiterte Lagerverwaltung eingetragen.
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return $this
	 */
	public function onCatalogProductSaveAfter($observer) {
		//Mage::log("extstock::catalog_product_save_after raised", Zend_Log::DEBUG, Egovs_Extstock_Helper_Data::LOG_FILE);

		if ($this->getData()) {
			Mage::log("extstock::Skipping onCatalogProductSaveAfterRaised --> data exists.", Zend_Log::DEBUG, Egovs_Extstock_Helper_Data::LOG_FILE);
			return $this;
		}

		$object = $observer->getProduct();
		//Egovs_Acl_Model_Product
		if (!($object instanceof Mage_Catalog_Model_Product)) {
			Mage::log("extstock::Skipping onCatalogProductSaveAfterRaised --> Product is no instance of Mage_Catalog_Model_Product.", Zend_Log::DEBUG, Egovs_Extstock_Helper_Data::LOG_FILE);
			return $this;
		}
		if (!$object->getId()) {
			$msg = "The product ID wasn't set!";
			Mage::log($msg, ZEND_log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::throwException($msg);
		}
			
		$extstock = array();

		$extstock['product_id'] = $object->getId();
		$extstock['distributor'] = Mage::app()->getRequest()->getPost(Egovs_Extstock_Helper_Data::DISTRIBUTOR_EDIT_ID);
		$extstock['price'] = Mage::app()->getRequest()->getPost(Egovs_Extstock_Helper_Data::COST_EDIT_ID);
		$extstock['date_ordered'] = Mage::app()->getRequest()->getPost(Egovs_Extstock_Helper_Data::DATE_ORDERED_EDIT_ID);
		$extstock['quantity_ordered'] = Mage::app()->getRequest()->getPost(Egovs_Extstock_Helper_Data::QTY_ORDERED_EDIT_ID);
		$extstock['storage'] = Mage::app()->getRequest()->getPost(Egovs_Extstock_Helper_Data::STORAGE_EDIT_ID);
		$extstock['rack'] = Mage::app()->getRequest()->getPost(Egovs_Extstock_Helper_Data::RACK_EDIT_ID);
		$extstock['status'] = Egovs_Extstock_Helper_Data::ORDERED; //Status muss 1 sein

		$this->setData($extstock);
		
		$collection = Mage::getModel('cataloginventory/stock_item')->getCollection()
        	->addFieldToFilter("product_id", array("eq" => $extstock['product_id']));
        
        $helper = Mage::helper('extstock');
        /*
		if (!$collection || $collection->getSize() < 1) {
			$msg = "Es ist eine unerwarteter Fehler aufgetreten. Es wurden keine Produkte gefunden, deren Lagerbestand geändert werden könnte.";
        	Mage::log($msg, ZEND_log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::getSingleton('adminhtml/session')->addError($msg);
        	Mage::throwException("Unknown error!");
        }
        */
        $manageStock = 0;
		foreach ($collection->getItems() as $item) {
        	if (!$item) {
        		continue;
        	}

       		$manageStock += $item->getManageStock();        	
        }
        
		if ($manageStock < 1) {
        		$msg = $helper->__("Extended Stock").": ";
        		$msg .= $helper->__("Product is not managed by stock [Product ID: %s]", $object->getId())."!";
				Mage::log("extstock::$msg", Zend_Log::NOTICE, Egovs_Extstock_Helper_Data::LOG_FILE);
				//Mage::getSingleton('adminhtml/session')->addWarning($msg);
				return $this;
        }
		//DB/modell aktionen ausführen
		//testen ob:
		//manage stock = true
		//product = simple (oder???) --> NOT grouped, bundled,
		//z.B. $object->getTypeId() != Mage_Catalog_Model_Product_Type::TYPE_GROUPED
		if (($extstock['quantity_ordered']+0) > 0
			&& Egovs_Extstock_Helper_Data::checkForUsableProductType($object->getTypeId())
		) {
			if ($extstock['price'] < 0) {
				$msg = $helper->__("Extended Stock").": ";
				$msg .= $helper->__("Price can't be less than 0, skipping extended stock save [Product ID: %s]", $object->getId())."!";
				Mage::log("extstock::$msg", Zend_Log::NOTICE, Egovs_Extstock_Helper_Data::LOG_FILE);
				Mage::getSingleton('adminhtml/session')->addWarning($msg);
				return $this;
			}
			$storeDate = Mage::app()->getLocale()->storeDate();
			$orderDate = Mage::app()->getLocale()->date($extstock['date_ordered']);
			if (!$extstock['date_ordered'] || is_null($extstock['date_ordered']) || $orderDate->isLater($storeDate, Zend_Date::DATE_MEDIUM)) {
				$msg = $helper->__("Extended Stock").": ";
				$msg .= $helper->__("Ordered date can't be tomorrow, skipping extended stock save [Product ID: %s]", $object->getId())."!";
				Mage::log("extstock::$msg", Zend_Log::NOTICE, Egovs_Extstock_Helper_Data::LOG_FILE);
				Mage::getSingleton('adminhtml/session')->addWarning($msg);
				return $this;
			}
			
			Mage::getModel('extstock/extstock')->setData($extstock)->save();
		} else {
			$isEmpty = true;
			foreach ($extstock as $key => $value) {
				if ($key == 'product_id'
					|| $key == 'status'
				) {
					continue;
				}
				
				if ($value && strlen($value) > 0) {
					$isEmpty = false;
					break;
				}				
			}
			
			if ($isEmpty) {
				return $this;
			}
				
			$msg = $helper->__("Extended Stock").": ";
			if (!Egovs_Extstock_Helper_Data::checkForUsableProductType($object->getTypeId())) {
				$msg .= $helper->__("Item not usable for extended stock, skipping extended stock save [Product ID: %s]", $object->getId())."!";
				Mage::log("extstock::$msg", Zend_Log::NOTICE, Egovs_Extstock_Helper_Data::LOG_FILE);
				return $this;
			} elseif (($extstock['quantity_ordered']+0) < 1) {
				$msg .= $helper->__("Ordered quantity is less than 1");
			} else {
				$msg .= $helper->__("Unknown reason");
			}
			$msg .= $helper->__(", skipping extended store save. [Product ID: %s]", $object->getId())."!";
			Mage::log("extstock::$msg", Zend_Log::NOTICE, Egovs_Extstock_Helper_Data::LOG_FILE);
			Mage::getSingleton('adminhtml/session')->addWarning($msg);
		}
				
		return $this;
	}
}