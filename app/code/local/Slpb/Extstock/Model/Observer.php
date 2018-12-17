<?php

class Slpb_Extstock_Model_Observer extends Mage_Core_Model_Abstract {

	/**
	 * Wird am Ende eines Verkaufsprozesses aufgerufen und verarbeitet die Abbuchung in der
	 * erweiterten Lagerverwaltung.
	 * 
	 * @param Varien_Event_Observer $observer
	 * @return $this
	 */
	public function onCheckoutTypeOnepageSaveOrderAfter($observer) {
		/*
		Mage::log("extstock::checkout_type_onepage_save_order_after raised"
			, Zend_Log::DEBUG
			, Slpb_Extstock_Helper_Data::LOG_FILE);
		*/
		$order = $observer->getData('order');
		
		if (!($order instanceof Mage_Sales_Model_Order))
			return;

		$shipping = $order->getShippingCarrier();
		//20110318 Frank Rochlitzer:
		//Bei Downloadprodukten ist shipping nicht gesetzt!
		if(is_null($shipping) || !$shipping || $shipping->getConfigData('decrease_event') != Slpb_Shipping_Model_System_Config_Decrease::DECREASE_ON_SALE){
				return;
		}
		
			
		$stock_id = $shipping->getConfigData('stock');		
			
			
		foreach ($order->getAllItems() as $item) {
			if (!($item instanceof Mage_Sales_Model_Order_Item))
				continue;

			try { 
				$product_id = $item->getData("product_id");
				$quantity = $item->getData("qty_ordered");
				$order_id = $item->getOrderID();
				
				//TODO: Was passiert wenn mehr bestellt sind als geliefert werden können?
				$toShip = $item->getQtyToShip();			
	
				if (!Slpb_Extstock_Helper_Data::checkForUsableProductType($item))
					continue;
	
				Mage::getModel('extstock/extstock')->decreaseQuantity($product_id, $quantity, $order_id, $stock_id);
			} catch (Exception $e)
			{
				Mage::log($e->getMessage(), Zend_Log::ALERT, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
			}				
		}
	}
	
	/**
	 * Wird ausgeführt wenn eine Bestellung storniert wird.
	 * 
	 * @param Varien_Event_Observer $observer
	 * @return $this
	 */
	public function onSalesOrderItemCancel($observer) {
		Mage::log("extstock::sales_order_item_cancel event raised", Zend_Log::DEBUG, Slpb_Extstock_Helper_Data::LOG_FILE);
		
		if(!$observer)
			return $this;
		
		if ($observer->getEvent()->getName() != "sales_order_item_cancel")
			return $this;
		
		$orderItem = $observer->getEvent()->getItem();
		
		$this->salesOrderItemCancelRefund($orderItem);
		
		return $this;
	}
	
	/**
	 * 
	 * @param Mage_Sales_Model_Order_Item $orderItem
	 * @return $this
	 */
	private function salesOrderItemCancelRefund($orderItem, $isRefund = false) {
		if (!$orderItem || !($orderItem instanceof Mage_Sales_Model_Order_Item))
			return $this;
		
		//Kindelemente von Configurable Products werden separat storniert!
		if (!Slpb_Extstock_Helper_Data::checkForUsableProductType($orderItem)) {
			Mage::log("extstock::Item [ID:".$orderItem->getId().";Product ID:".$orderItem->getProductID()."] is not useable with extended store."
				, Zend_Log::NOTICE
				, Slpb_Extstock_Helper_Data::LOG_FILE);
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
     * @param   Varien_Event_Observer $observer
     * @return  $this
     */
    public function refundOrderItem($observer)
    {
    	Mage::log("extstock::sales_creditmemo_item_save_after event raised", Zend_Log::DEBUG, Slpb_Extstock_Helper_Data::LOG_FILE);
        
    	$item = $observer->getEvent()->getCreditmemoItem();
        if ($item->getId() && $item->getBackToStock() && ($productId = $item->getProductId()) && ($qty = $item->getQty())) {
        	$orderItem = $item->getOrderItem();
			
			$this->salesOrderItemCancelRefund($orderItem, true);
        }
        return $this;
    }

	/**
	 * 
	 * @param Varien_Event_Observer $observer
	 * @return $this
	 */
	public function onPrepareTabLayout($observer)
	{
		if($observer == null) return;

		$form = $observer->getData('form');
		$product = $observer->getData('product');

		if(($form == null) || ($product == null)) return;
		Mage::getSingleton('adminhtml/session')->setData('extstockmode','product');
		Mage::getSingleton('adminhtml/session')->setData('extstockproduct',$product->getEntityId()); 
		if (Slpb_Extstock_Helper_Data::checkForUsableProductType($product->getTypeId()))
		{
			$form->addTab('extinventory', array(
                'label'     => Mage::helper('catalog')->__('Extended Inventory'),
                'content'   => $form->getLayout()->createBlock('extstock/adminhtml_catalog_product_edit_tab_extstock','',array('product'=>$product))
			->toHtml(),
			));
		}
		
		return $this;
	}

	/**
	 * Wird aufgerufen, nach dem ein Produkt gespeichert wurde.
	 * Falls vorhanden, werden Daten in die erweiterte Lagerverwaltung eingetragen.
	 * 
	 * @param Varien_Event_Observer $observer
	 * @return $this
	 */
	public function onCatalogProductSaveAfter($observer) {
		//Mage::log("extstock::catalog_product_save_after raised", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

		if ($this->getData()) {
			Mage::log("extstock::Skipping onCatalogProductSaveAfterRaised --> data exists.", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			return $this;
		}

		$object = $observer->getProduct();
		//Slpb_Acl_Model_Product
		if (!($object instanceof Mage_Catalog_Model_Product)) {
			Mage::log("extstock::Skipping onCatalogProductSaveAfterRaised --> Product is no instance of Mage_Catalog_Model_Product.", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			return $this;
		}
		if (!$object->getId()) {
			$msg = "The product ID wasn't set!";
			Mage::log($msg, ZEND_log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::throwException($msg);
		}

		$this->saveStockMovment($object->getId());
		
		$extstock = array();

		$extstock['product_id'] = $object->getId();
		$extstock['distributor'] = Mage::app()->getRequest()->getPost(Slpb_Extstock_Helper_Data::DISTRIBUTOR_EDIT_ID);
		$extstock['price'] = Mage::app()->getRequest()->getPost(Slpb_Extstock_Helper_Data::COST_EDIT_ID);
		$extstock['date_ordered'] = Mage::app()->getRequest()->getPost(Slpb_Extstock_Helper_Data::DATE_ORDERED_EDIT_ID);
		$extstock['quantity_ordered'] = Mage::app()->getRequest()->getPost(Slpb_Extstock_Helper_Data::QTY_ORDERED_EDIT_ID);
		$extstock['storage'] = Mage::app()->getRequest()->getPost(Slpb_Extstock_Helper_Data::STORAGE_EDIT_ID);
		$extstock['rack'] = Mage::app()->getRequest()->getPost(Slpb_Extstock_Helper_Data::RACK_EDIT_ID);
		$extstock['status'] = Slpb_Extstock_Helper_Data::ORDERED; //Status muss 1 sein
		$extstock['stock_id'] = Mage::app()->getRequest()->getPost('exts_order_stock_id');
		$this->setData($extstock);
		
		$collection = Mage::getModel('cataloginventory/stock_item')->getCollection()
        	->addFieldToFilter("product_id", array("eq" => $extstock['product_id']));
        
        $helper = Mage::helper('extstock');
		if (!$collection || $collection->getSize() < 1) {
			$msg = "Es ist eine unerwarteter Fehler aufgetreten. Es wurden keine Produkte gefunden, deren Lagerbestand gaendert werden könnte.";
        	Mage::log($msg, ZEND_log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			Mage::getSingleton('adminhtml/session')->addError($msg);
        	Mage::throwException("Unknown error!");
        }
        
        $manageStock = 0;
		foreach ($collection->getItems() as $item) {
        	if (!$item)
        		continue;

       		$manageStock += $item->getManageStock();        	
        }
        
		if ($manageStock < 1) {
        		$msg = $helper->__("Extended Stock").": ";
        		$msg .= $helper->__("Product is not managed by stock [Product ID: %s]", $object->getId())."!";
				Mage::log("extstock::$msg", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
				//Mage::getSingleton('adminhtml/session')->addWarning($msg);
				return $this;
        }
		//DB/modell aktionen ausführen
		//testen ob:
		//manage stock = true
		//product = simple (oder???) --> NOT grouped, bundled,
		//z.B. $object->getTypeId() != Mage_Catalog_Model_Product_Type::TYPE_GROUPED
		if(($extstock['quantity_ordered']+0) > 0
			&& Slpb_Extstock_Helper_Data::checkForUsableProductType($object->getTypeId()))
		{
			if ($extstock['price'] < 0) {
				$msg = $helper->__("Extended Stock").": ";
				$msg .= $helper->__("Price can't be less than 0, skipping extended stock save [Product ID: %s]", $object->getId())."!";
				Mage::log("extstock::$msg", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
				Mage::getSingleton('adminhtml/session')->addWarning($msg);
				return $this;
			}
			$storeDate = Mage::app()->getLocale()->storeDate();
			$orderDate = Mage::app()->getLocale()->date($extstock['date_ordered']);
			if (!$extstock['date_ordered'] || is_null($extstock['date_ordered']) || $orderDate->isLater($storeDate, Zend_Date::DATE_MEDIUM)) {
				$msg = $helper->__("Extended Stock").": ";
				$msg .= $helper->__("Ordered date can't be tomorrow, skipping extended stock save [Product ID: %s]", $object->getId())."!";
				Mage::log("extstock::$msg", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
				Mage::getSingleton('adminhtml/session')->addWarning($msg);
				return $this;
			}
			
			Mage::getModel('extstock/extstock')->setData($extstock)->save();
		} else {
			$isEmpty = true;
			foreach($extstock as $key => $value) {
				if ($key == 'product_id'
					|| $key == 'status'
					|| $key == 'stock_id')
					continue;
				
				if ($value && strlen($value) > 0) {
					$isEmpty = false;
					break;
				}				
			}
			
			if ($isEmpty)
				return $this;
				
			$msg = $helper->__("Extended Stock").": ";
			if (!Slpb_Extstock_Helper_Data::checkForUsableProductType($object->getTypeId())) {
				$msg .= $helper->__("Item not usable for extended stock, skipping extended stock save [Product ID: %s]", $object->getId())."!";
				Mage::log("extstock::$msg", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
				return $this;
			} elseif (($extstock['quantity_ordered']+0) < 1) {
				$msg .= $helper->__("Ordered quantity is less than 1");
			} else {
				$msg .= $helper->__("Unknown reason");
			}
			$msg .= $helper->__(", skipping extended store save. [Product ID: %s]", $object->getId())."!";
			Mage::log("extstock::$msg", Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
			Mage::getSingleton('adminhtml/session')->addWarning($msg);
			
			

			
		}
				
		return $this;
	}
	
	public function onSalesOrderShipmentSaveAfter($observer)
	{
		
		$ship = $observer->getData('shipment');
		
		if (!($ship instanceof Mage_Sales_Model_Order_Shipment))
			return;
		
		$carrier = $ship->getOrder()->getShippingCarrier();
		
		if(!$carrier) { return; }
		
		if($carrier->getConfigData('decrease_event') != Slpb_Shipping_Model_System_Config_Decrease::DECREASE_ON_SHIPPING){
				return;
		}
		
		$stock_id = $carrier->getConfigData('stock');
		$order_id = $ship->getOrder()->getId();

		foreach ($ship->getAllItems() as $item) {
			if (!($item instanceof Mage_Sales_Model_Order_Shipment_Item))
				continue;

			try { 
				$product_id = $item->getProductId();
				$quantity = $item->getQty();
	
				if (!Slpb_Extstock_Helper_Data::checkForUsableProductType($item))
					continue;
	
				Mage::getModel('extstock/extstock')->decreaseQuantity($product_id, $quantity, $order_id, $stock_id);
			} catch (Exception $e)
			{
				Mage::log($e->getMessage(), Zend_Log::ALERT, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
			}				
		}
		
	}
	
	private function saveStockMovment($product_id)
	{
			//extstock2
			
			try
			{
				$extstock = array();
	
				$extstock['product_id'] = $product_id;
				$extstock['date_ordered'] = Mage::app()->getRequest()->getPost('exts_move_date_ordered');
				//$extstock['date_delivered'] = Mage::app()->getRequest()->getPost(Slpb_Extstock_Helper_Data::DATE_ORDERED_EDIT_ID);	
				$extstock['qty_ordered'] = Mage::app()->getRequest()->getPost('exts_move_qty');
				$extstock['qty'] = Mage::app()->getRequest()->getPost('exts_move_qty');
				$extstock['output_stock_id'] = Mage::app()->getRequest()->getPost('exts_move_source');
				$extstock['input_stock_id'] = Mage::app()->getRequest()->getPost('exts_move_destination');
				$extstock['status'] = Mage::app()->getRequest()->getPost('exts_move_status');
				$extstock['note'] = Mage::app()->getRequest()->getPost('exts_move_note');
				$extstock['user_ident'] = Mage::getSingleton('admin/session')->getUser()->getId();
				$extstock['desired_date'] = Mage::app()->getRequest()->getPost('exts_move_date_desired');
				
				$isEmpty = true;
				foreach($extstock as $key => $value) {
					if ($key == 'qty_ordered'){
						if ($value && strlen($value) > 0) {
							$isEmpty = false;
							break;
						}
					}
				}	
				
				if($isEmpty) return;
				
				$item = Mage::getModel('extstock/journal');
				$item->setData($extstock);
				if($item->getStatus() != Slpb_Extstock_Model_Journal::STATUS_DELIVERED){
					$stock = Mage::getModel('extstock/stock')->load($item->getInputStockId());
					if($stock->getType() == Slpb_Extstock_Model_Stock::STORETYP_LOSS){
						$item->setStatus(Slpb_Extstock_Model_Journal::STATUS_DELIVERED);
						$item->setDateDelivered($item->getDateOrdered());
						$item->setQty($item->getQtyOrdered());
					}
				}
				
				$product_id = $item->getProductId();
				$qty = $item->getQty();
				$from_stock_id = $item->getOutputStockId();
				$to_stock_id = $item->getInputStockId();
				
				
				if (!$from_stock_id) {
					Mage::throwException("Output Stock not specified!");
				}
				if (!$to_stock_id) {
					Mage::throwException("Input Stock not specified!");
				}
				
				if (!$product_id) {
					Mage::throwException("Product not specified!");
				}


				$stid = $this->createStockOrder($to_stock_id,$from_stock_id,$item->getDateOrdered(),$item->getDesiredDate(), $item->getNote());
				$item->setData('deliveryorder_increment_id',$stid);
				
				$item->save();
				$journal_id = $item->getId();
				if($item->getStatus()== Slpb_Extstock_Model_Journal::STATUS_DELIVERED)	
				{
					$rest = Mage::getModel('extstock/extstock')->moveQuantity($product_id, $qty, $from_stock_id, $to_stock_id, $journal_id);
					if($rest > 0)
					{
						Mage::getSingleton('adminhtml/session')->addError("Konnte $rest nicht umbuchen");
						Mage::log("extstock::move Rest=". $rest . " ProductId=". $product_id, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
					}
				}
				
				Mage::getSingleton('adminhtml/session')->addSuccess( Mage::helper('extstock')->__('Stock Movement %s has been created.', $stid));
				
			}
			catch(Exception $ex)
			{
				Mage::log("extstock::".$ex->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
			}
	}
	
	protected function createStockOrder($instockid,$outstockid,$order_date,$desired_date, $note)
	{
		$order_date =  Mage::getModel('core/date')->date(null,$order_date);
		$desired_date =Mage::getModel('core/date')->date(null,$desired_date);
		$owner = Mage::getSingleton('admin/session')->getUser();
		$stockorder = Mage::getModel('extstock/stockorder');
		$stockorder->setDateOrdered($order_date);
		$stockorder->setUser($owner->getName());
		$stockorder->setInstockId(intval($instockid));
		$stockorder->setOutstockId(intval($outstockid));
		$stockorder->setDesiredDate($desired_date);
		$stockorder->setNote($note);
		$stockorder->save();
		$this->_StockOrderId = $stockorder->getId();
		return $this->_StockOrderId;
	}
}