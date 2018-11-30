<?php

class Slpb_Extstock_Model_Extstock extends Mage_Core_Model_Abstract
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
     * Sollte nur noch im Fall einer gelieferten Bestellung gerufen werden
     * @param bool $isCancel Unterbindet bei Stornierungen die Überprüfung der Datumsangaben
     * 
     * (non-PHPdoc)
     * @see downloader/pearlib/download/Mage_Core_Modules-1.3.2.4/Mage/Core/Model/Mage_Core_Model_Abstract#save()
     */
    public function save($isCancel = false)
    {
    	$helper = Mage::helper('extstock');
    	$storeDate = Mage::app()->getLocale()->storeDate();
    	
    	if ($this->getIdFieldName() == "extstock_id"
    		&& $this->hasData()) {
    		
    		/*
    		 * 20100923: Frank Rochlitzer
    		 * Überprüfung muss bei Storno deaktiviert sein (#503)
    		 */
    		if (!$isCancel) {
	    		if ($this->getDateOrdered() && !is_null($this->getDateOrdered())) {
	    			$date = Mage::app()->getLocale()->date($this->getDateOrdered());
	    						
		    		if ($date && $date->isLater($storeDate, Zend_Date::DATE_MEDIUM)) {
		    			Mage::throwException($helper->__("Order date can't be tomorrow."));
		    		}
	    		}
	    		if ($this->getDateDelivered() && !is_null($this->getDateDelivered())) {
		    		$date = Mage::app()->getLocale()->date($this->getDateDelivered());
		    		if ($date && $date->isLater($storeDate, Zend_Date::DATE_MEDIUM)) {
		    			Mage::throwException($helper->__("Delivery date can't be tomorrow."));
		    		}
	    			if ($date && $date->isEarlier(Mage::app()->getLocale()->date($this->getDateOrdered()))) {
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

    			if (!$isCancel && $this->getStatus() != Slpb_Extstock_Helper_Data::DELIVERED) {
    				$msg = $helper->__("Delivery date was set but item was not set to delivered [Product ID: %s].", $this->getData('product_id'));
					Mage::log("extstock::".$msg, Zend_Log::NOTICE, Slpb_Extstock_Helper_Data::LOG_FILE);
					Mage::getSingleton('adminhtml/session')->addWarning($msg);
    			}
    		}
    		
    		if ($this->getQuantity() < 0) {
    			Mage::throwException($helper->__("Available quantity can't be lesser than zero!"));
    		} else {
    			if ($this->getQuantity() > $this->getQuantityOrdered()) {
    				Mage::throwException($helper->__("Available quantity can't be greater than quantity ordered!"));
    			}
    		}
    	}
	
    	parent::save();
    	
   	
    	if (!$isCancel)
    	{
	    	//Magetoeigenen Zaehler incrementieren, falls geliefert 	
	    	if($this->getStatus() == Slpb_Extstock_Helper_Data::DELIVERED)
	    	{
		    	//falls nicht SchwundLager hinzufuegen
		    	if(!Mage::getModel('extstock/stock')->getIsLoss($this->getStockId()))
		    	{
				    $this->increaseMagentoQuantity($this->getProductId(),$this->getQuantity());
		    	}
	    	}
    	}
        return $this;
    }
    
    //wird nur bei Lagerbewegungen aufgerufen -> MagentoMenge wird nicht ver�ndert
    public function moveQuantity($product_id, $qty, $from_stock_id, $to_stock_id, $journal_id) 
    {
    	$coll = Mage::getModel('extstock/extstock')->getCollection();
    	$coll->getSelect()
    		->where('product_id=?',$product_id)
    		->where('quantity >= 0')
    		->where('stock_id=?',$from_stock_id)
    		->order("date_ordered")
    		->order("extstock_id");
    	//die($coll->getSelect()->__ToString());
    	
    	foreach ($coll->getItems() as $item)
    	{
    		//falls genug da ist
    		if($item->getQuantity() >= $qty) 
    		{
    			$menge = $qty;
    		}
    		//false nicht
    		else
    		{
    			$menge = $item->getQuantity();
    		}
    		if($menge > 0)
    		{
    			//ziellager
	    		$move = Mage::getModel('extstock/extstock');
	    		$move->setData('product_id',$product_id);
	    		$move->setData('quantity',$menge);
	    		$move->setData('quantity_ordered',$menge);
	    		$move->setData('status',Slpb_Extstock_Helper_Data::DELIVERED);
	    		$move->setData('stock_id',$to_stock_id);
	    		$move->setData('date_ordered',date('Y-m-d'));
	    		$move->setData('date_delivered',date('Y-m-d'));
	    		$move->setData('parent_extstock_id',$item->getId());
	    		$move->setData('journal_id',$journal_id);
	    		
	    		//rest klonen
	    		$move->setData('price',$item->getData('price'));
	    		$move->setData('distributor',$item->getData('distributor'));
	    		$move->setData('storage',$item->getData('storage'));
	    		$move->setData('rack',$item->getData('rack'));
	    		$move->saveDirect();
	    		$item->setData('quantity',$item->getQuantity()- $menge);
	    		$item->saveDirect();
	    	
		    	//falls nicht SchwundLager abziehen
		    	if(Mage::getModel('extstock/stock')->getIsLoss($move->getStockId()))
		    	{
		    		$this->decreaseMagentoQuantity($move->getProductId(),$menge);
		    	}
    		}
    		$qty = $qty - $menge;
    		if($qty <= 0) break;    		
    	}
    	return $qty;
    }
    
    
    //speichern des Models ohne Ueberpruefungen, und mainipulationen
    public function saveDirect()
    {

    	parent::save();
    }
    
    
    
    public function decreaseMagentoQuantity($product_id, $quantity)
    {
    	$stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product_id);
		
		if($quantity > $stockItem->getQty())
		{
			$quantity = $stockItem->getQty();
		}
		if($quantity > 0)
		{
			$stockItem->subtractQty($quantity);
			$stockItem->save();
		}
	}
	
   	public function increaseMagentoQuantity($product_id, $quantity)
    {
		if($quantity > 0)
		{
			$stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product_id);
			$stockItem->addQty($quantity);
			$stockItem->save();
		}
	}
    
    /**
     * Bucht von dem entsprechenden Produkt in der erwweiterten Lagerverwaltung die entsprechende Menge ab.
     * 
     * @param integer $product_id Produkt ID
     * @param integer $qty Menge die abgebucht werden soll
     * @param integer $order_id Order ID der Bestellung
     * @return $this
     */
    public function decreaseQuantity($product_id, $qty, $order_id, $stock_id) {
    	$coll = Mage::getModel('extstock/extstock')->getCollection();
    	
    	if (!$order_id) {
    		Mage::log("extstock::No 'order_id' found for product [Product ID:$product_id, Order ID: $order_id]. Can't store sales order to database for extended store."
    			, Zend_Log::ALERT
    			, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    		return $this;
    	}
    	
    	if (!$coll) {
    		Mage::log("extstock::Can't get collection for extstock [Product ID:$product_id, Order ID: $order_id]. Can't store sales order to database for extended store."
    			, Zend_Log::ALERT
    			, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    		return $this;
    	}
    	$extstockMap = $coll->decreaseQuantityPerProduct($product_id, $qty, $stock_id);
    	if ($extstockMap === false
    		|| !is_array($extstockMap)) {
    		Mage::log("extstock::No decreased items found. [Product ID:$product_id, Order ID: $order_id]. Can't store sales order to database for extended store."
    			, Zend_Log::WARN
    			, Slpb_Extstock_Helper_Data::LOG_FILE);
    		return $this;
    	}
    		
    	$salesOrderModel = Mage::getModel("extstock/salesorder");
    	
    	if (!$salesOrderModel) {
    		Mage::log("extstock::Can't get sales order model [Product ID:$product_id, Order ID: $order_id]. Can't store sales order to database for extended store."
    			, Zend_Log::ALERT
    			, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    		return $this;
    	}
		
    	foreach ($extstockMap as $pair) {
    		if (!array_key_exists("id", $pair)) {
    			Mage::log("extstock::Key 'id' for extstock_id' not found to insert sales order [ID:$order_id] to database."
    			, Zend_Log::ALERT
    			, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    			continue;
    		}
    		if (!array_key_exists("qty", $pair)) {
    			Mage::log("extstock::Key 'qty' for 'quantity' not found to insert sales order [ID:$order_id] to database."
    			, Zend_Log::ALERT
    			, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    			continue;
    		}
    		
    		if (!$stock_id) {
    			$item = Mage::getModel('extstock/extstock')->load($pair["id"]);
    			if ($item) {
    				$stock_id = $item->getStockId();
    				Mage::log("extstock::No default stock ID found using stock id from extstock item ID: $stock_id",
    					Zend_Log::NOTICE,
    					Slpb_Helper::LOG_FILE)
    				;
    			}
    		}
	    	$salesOrder = array(
	    		  "extstock_id" => $pair["id"]
	    		, "sales_order_id" => $order_id
	    		, "qty_ordered" => $pair["qty"]
	    		,"stock_id" => $stock_id
	    		
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
	    		if($data['status'] == Slpb_Extstock_Helper_Data::DELIVERED)
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
}