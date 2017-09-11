<?php

class Egovs_Extstock_Model_Extstock extends Mage_Core_Model_Abstract
{
	private $savingInProcess = false;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('extstock/extstock');
    }
    
    public function isSaving() {
    	return $this->savingInProcess;
    }
    
	/**
     * Processing object before save data
     *
     * @return Mage_Core_Model_Abstract
     */
    protected function _beforeSave()
    {
        $this->savingInProcess = true;
        
        return parent::_beforeSave();
    }
    
    protected function _afterSave()
    {
    	$this->savingInProcess = false;
        
        return parent::_afterSave();
    }
    
    /**
     * Speichert das Model persistent in der Datenbank.
     * 
     * @param boolean $isCancel Unterbindet bei Stornierungen die Überprüfung der Datumsangaben
     * 
     * @return Egovs_Extstock_Model_Extstock
     * 
     * (non-PHPdoc)
     * @see downloader/pearlib/download/Mage_Core_Modules-1.3.2.4/Mage/Core/Model/Mage_Core_Model_Abstract#save()
     */
    public function save($isCancel = false)
    {
    	$helper = Mage::helper('extstock');
    	$storeDate = Mage::app()->getLocale()->storeDate();
    	//Zend_Date wird im Debugging nicht angezeigt
    	//$storeDateArray = $storeDate->toArray();
    	
    	if ($this->getIdFieldName() == "extstock_id"
    		&& $this->hasData()) {
    		
    		/*
    		 * 20100923: Frank Rochlitzer
    		 * Überprüfung muss bei Storno deaktiviert sein (#503)
    		 */
    		if (!$isCancel) {
	    		if ($this->getDateOrdered() && !is_null($this->getDateOrdered())) {
	    			$date = Mage::app()->getLocale()->date($this->getDateOrdered());
	    			//Uhrzeit auf 0 Uhr setzen, damit es mit storeDate übereinstimmt
	    			$date->setHour(0)
	    				->setMinute(0)
	    				->setSecond(0)
	    			;
	    			//Zend_Date wird im Debugging nicht angezeigt
// 	    			$dateArray = $date->toArray();
		    		if ($date && $date->isLater($storeDate, Zend_Date::DATE_MEDIUM)) {
		    			Mage::throwException($helper->__("Order date can't be tomorrow."));
		    		}
	    		}
	    		if ($this->getDateDelivered() && !is_null($this->getDateDelivered())) {
		    		$date = Mage::app()->getLocale()->date($this->getDateDelivered());
		    		//Uhrzeit auf 0 Uhr setzen, damit es mit storeDate übereinstimmt
		    		$date->setHour(0)
			    		->setMinute(0)
			    		->setSecond(0)
		    		;
		    		if ($date && $date->isLater($storeDate, Zend_Date::DATE_MEDIUM)) {
		    			Mage::throwException($helper->__("Delivery date can't be tomorrow."));
		    		}
	    			if ($date && $date->isEarlier(
	    					Mage::app()->getLocale()->date($this->getDateOrdered())
	    						->setHour(0)
			    				->setMinute(0)
			    				->setSecond(0)
	    				)
	    			) {
		    			Mage::throwException($helper->__("Delivery date can't be before order date!"));
		    		}
		    		$maxMonthsBack = 6;
	    			if ($date && $date->isEarlier(Mage::app()->getLocale()->storeDate()->subMonth($maxMonthsBack))) {
		    			Mage::throwException($helper->__("Delivery date can be only %s months back.", $maxMonthsBack));
		    		}	
		    	}
    		}
    		
	    	if ($this->getDateOrdered() && !is_null($this->getDateOrdered())) {
	    		$date = $this->getDateOrdered();
	    		$date = Mage::getModel('core/date')->gmtDate(null,$date);
	//			$date = Mage::app()->getLocale()->date($this->getDateOrdered());
	//			$date = $date->toString();
	    		$this->setData('date_ordered', $date);
	    	}
    		
    		if ($this->getDateDelivered() && !is_null($this->getDateDelivered())) {
    			//getDateDelivered liefert jetzt Zend_Date
    			$date = Mage::getModel('core/date')->gmtDate(null, $this->getDateDelivered());
    			$this->setData('date_delivered', $date);

    			if (!$isCancel && $this->getStatus() != Egovs_Extstock_Helper_Data::DELIVERED) {
    				$msg = $helper->__("Delivery date was set but item was not set to delivered [Product ID: %s].", $this->getData('product_id'));
					Mage::log("extstock::".$msg, Zend_Log::NOTICE, Egovs_Extstock_Helper_Data::LOG_FILE);
					Mage::getSingleton('adminhtml/session')->addWarning($msg);
    			}
    		}
    		$req = Mage::app()->getRequest();
    		if ($req->getActionName() == 'save' && ($req->getControllerName() == 'catalog_product' || $req->getControllerName() == 'adminhtml_extstock')) {
	    		if ($this->getQuantity() < 0) {
	    			Mage::throwException($helper->__("Available quantity can't be lesser than zero!"));
	    		} else {
	    			if ($this->getQuantity() > $this->getQuantityOrdered()) {
	    				Mage::throwException($helper->__("Available quantity can't be greater than quantity ordered!"));
	    			}
	    		}
    		}
    	}
	
    	parent::save();
    	
        $this->saveToMagentoStock($this->getProductID());
        
        return $this;
    }
    
    protected function saveToMagentoStock($product_id)
    {
    	if ($this->getOmitMagentoStockUpdate() == true) {
    		return $this;
    	}
    	$collection = Mage::getModel('cataloginventory/stock_item')->getCollection()
    		->addFieldToFilter("product_id", array("eq" => $product_id));
    	
    	$extstockColl = Mage::getModel('extstock/extstock')->getCollection()
    		->addFieldToFilter("product_id", array("eq" => $product_id))
    		->addFieldToFilter("status", array("eq" => Egovs_Extstock_Helper_Data::DELIVERED));
    	
    	if (!$collection || $collection->getSize() < 1) {
    		$msg = $helper->__("An unexpected error occured.");
    		$msg .= " ".$helper->__("No products found to change stock value.");
    		Mage::getSingleton('adminhtml/session')->addError($msg);
    		Mage::throwException("Unknown error: $msg");
    	}
    	
    	foreach ($collection->getItems() as $item) {
    		$totalQty = 0;
    		foreach ($extstockColl->getItems() as $exItem) {
    			$totalQty += $exItem->getQuantity();
    		}
    		 
    		//$item->addAttributeUpdate("qty", $totalQty, $storeID);
    		if ($item->getQty() != $totalQty) {
	    		$item->setData("qty", $totalQty)
	    			->save()
	    		;
    		}
    	}
    	
    	return $this;
    } 
    
    /**
     * Bucht von dem entsprechenden Produkt in der erwweiterten Lagerverwaltung die entsprechende Menge ab.
     * 
     * @param integer Mage_Catalog_Model_Product $product_id Produkt ID
     * @param integer $qty Menge die abgebucht werden soll
     * @param integer Mage_Sales_Model_Order $order_id Order ID der Bestellung
     * @return $this
     */
    public function decreaseQuantity($product_id, $qty, $order_id) {
    	$coll = Mage::getModel('extstock/extstock')->getCollection();
    	
    	if (!$order_id) {
    		Mage::log("extstock::No 'order_id' found for product [Product ID:$product_id, Order ID: $order_id]. Can't store sales order to database for extended store."
    			, Zend_Log::ALERT
    			, Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    		return $this;
    	}
    	
    	if (!$coll) {
    		Mage::log("extstock::Can't get collection for extstock [Product ID:$product_id, Order ID: $order_id]. Can't store sales order to database for extended store."
    			, Zend_Log::ALERT
    			, Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    		return $this;
    	}
    	$extstockMap = $coll->decreaseQuantityPerProduct($product_id, $qty);
    	if ($extstockMap === false
    		|| !is_array($extstockMap)) {
    		Mage::log("extstock::No decreased items found. [Product ID:$product_id, Order ID: $order_id]. Can't store sales order to database for extended store."
    			, Zend_Log::WARN
    			, Egovs_Extstock_Helper_Data::LOG_FILE);
    		return $this;
    	}
    		
    	$salesOrderModel = Mage::getModel("extstock/salesorder");
    	
    	if (!$salesOrderModel) {
    		Mage::log("extstock::Can't get sales order model [Product ID:$product_id, Order ID: $order_id]. Can't store sales order to database for extended store."
    			, Zend_Log::ALERT
    			, Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    		return $this;
    	}
		
    	foreach ($extstockMap as $pair) {
    		if (!array_key_exists("id", $pair)) {
    			Mage::log("extstock::Key 'id' for extstock_id' not found to insert sales order [ID:$order_id] to database."
    			, Zend_Log::ALERT
    			, Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    			continue;
    		}
    		if (!array_key_exists("qty", $pair)) {
    			Mage::log("extstock::Key 'qty' for 'quantity' not found to insert sales order [ID:$order_id] to database."
    			, Zend_Log::ALERT
    			, Egovs_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    			continue;
    		}
	    	$salesOrder = array(
	    		  "extstock_id" => $pair["id"]
	    		, "sales_order_id" => $order_id
	    		, "qty_ordered" => $pair["qty"]
	    	);
			
	    	//TODO: Vielleicht besser über Collection realisieren, um nur einmal save zu machen???
	    	//setData kann immer nur einen Datensatz enthalten!!!
	    	$salesOrderModel->setData($salesOrder);
    		//Falls save nicht hier ausgeführt wird, gehen Daten verloren!!!
	    	$salesOrderModel->save();
    	}    	    	
    }
    
    /**
     * Falls Status auf geliefert: menge = bestellmenge
     * @param array $data
     * @return array
     */
    public function setQuantity($data)
    {
    	if (is_array($data)) {
	    	if(isset($data['status']))
	    	{
	    		if($data['status'] == Egovs_Extstock_Helper_Data::DELIVERED)
	    		{
	    			$data = array_merge($data,array('quantity'=>$data['quantity_ordered']));
	    		}
	    	}
    	} 
    	return $data;
    }
    
   	public function getData($key='', $index=null) {
   		$data = parent::getData($key, $index);
   		
   		//falls Model gerade nicht gespeichert wird --> GMT Offset einbeziehen!!!
   		//sonst geht speichern schief
   		if ($this->isSaving())
   			return $data;
   			
   		if (is_array($data)) {
	   		if (array_key_exists('date_delivered', $data)) {
	   			$date = $data['date_delivered'];
	   			if ($date && !is_null($date)) {
					$date = Mage::app()->getLocale()->date($date);
					if ($date->toValue(Zend_Date::YEAR) <= 0) {
		   				$data['date_delivered'] = null;
		   			} else $data['date_delivered'] = $date->toString();
	   			}
			}
			if (array_key_exists('date_ordered', $data)) {
				$date = $data['date_ordered'];
	   			if ($date && !is_null($date)) {
					$date = Mage::app()->getLocale()->date($date);
					if ($date->toValue(Zend_Date::YEAR) <= 0) {
		   				$data['date_ordered'] = null;
		   			} else $data['date_ordered'] = $date->toString();
	   			}
			}
	   	} elseif ($key == 'date_ordered' || $key == 'date_delivered') {
	   		if ($data && !is_null($data)) {
	   			$data = Mage::app()->getLocale()->date($data);
	   			if ($data->toValue(Zend_Date::YEAR) <= 0) {
	   				$data = null;
	   			} else $data->toString();
	   		}
	   	}
   		
   		return $data;
   	}
   	
   	
   	
   	public function adjustInventory($product_id, $adjust_qty)
   	{
   		if($adjust_qty == 0) return $this;
   		$date = Mage::getModel('core/date')->gmtDate(null);
   		$this->setData('product_id',$product_id);
   		$this->setData('distributor',Mage::helper('extstock')->__("adjust Inventory"));
   		$this->setData('price',0);
   		$this->setData('date_ordered',$date);
   		$this->setData('date_delivered',$date);
   		$this->setData('quantity_ordered',$adjust_qty);
   		$this->setData('quantity',$adjust_qty);
   		$this->setData('storage',"");
   		$this->setData('rack',"");
   		$this->setData('status',Egovs_Extstock_Helper_Data::DELIVERED);
   		
   		parent::save();
   		
   		$this->saveToMagentoStock($product_id);
   		
   		return $this;
   	} 
   	
   	
}