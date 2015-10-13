<?php

/**
 * 
 *  Erweitete Lagerverwaltung mit mehreren Lagern und Transferbuchungen
 *  @category Egovs
 *  @package  Slpb_Extstock_Model_Mysql4_Extstock_Collection
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Slpb_Extstock_Model_Mysql4_Extstock_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	private $_filter = null;
	private $_namefilter = null;
	private $_skufilter = null;
	private $_lagerfilter = null;
	private $_bestellfilter = null;
	
	public function _construct()
	{
		parent::_construct();
		$this->_init('extstock/extstock');	
	}
	
	protected function _initSelect()
	{
		parent::_initSelect();
		$select = $this->getSelect()
		//->reset() //addFieldToFilter(..) gehen verloren!!!!
		//->reset(Zend_Db_Select::ORDER)
		//->reset(Zend_Db_Select::LIMIT_COUNT)
		//->reset(Zend_Db_Select::LIMIT_OFFSET)
		->columns(array('lagerwert'=>'(quantity * price)','bestellwert'=>'(quantity_ordered * price)'))
		//->reset(Zend_Db_Select::INNER_JOIN)
		//->reset(Zend_Db_Select::GROUP)
		->join(array('e'=>(string)Mage::getConfig()->getTablePrefix().'catalog_product_entity'),'main_table.product_id = e.entity_id',array('sku'))
		->join(array('att'=>(string)Mage::getConfig()->getTablePrefix().'catalog_product_entity_varchar'),'att.entity_id = main_table.product_id',array('name'=>'value'))
		->join(array('ea'=>$this->getTable('eav/attribute')),'att.attribute_id=ea.attribute_id',array())
		->join(array('et'=>$this->getTable('eav/entity_type')),'ea.entity_type_id = et.entity_type_id',array())
		->where("et.entity_type_code = 'catalog_product'")
		->where("ea.attribute_code = 'name'")
		->group('main_table.extstock_id');
		
		//die($select->__toString());
		
	}

	public function addFilterString($filter)
	{
		$this->_filter = $filter;
	}

	public function addFilterOnlyStockOrders()
	{
		$this->getSelect()->where('journal_id is null');
	}
	
   public function getSize()
    {
    	$select = clone($this->getSelect());
    	$select->reset(Zend_Db_Select::LIMIT_COUNT); 
    	
    	
    	$sql = 'select count(sub.extstock_id) as cnt from ('.$select->__toString().') as sub';
    	$res = $this->getConnection()->fetchAll($sql);
    	if(count($res)>0)
    	{
    		return $res[0]['cnt'];
    	}
    	
    	return 0;
    }
	
	
	public function load($printQuery = false, $logQuery = false)
	{
		/*
		 SELECT  stock.*, att.value as name, e.sku FROM extstock stock
		 inner join catalog_product_entity e on stock.product_id = e.entity_id
		 inner join catalog_product_entity_varchar att on att.entity_id = e.entity_id
		 inner join eav_attribute ea on att.attribute_id=ea.attribute_id
		 inner join eav_entity_type et on ea.entity_type_id = et.entity_type_id
		 WHERE et.entity_type_code = 'catalog_product'
		 AND ea.attribute_code = 'name'
		 group by stock.extstock_id
		 */

		if ($this->isLoaded()) {
			return $this;
		}


	 	//var_dump($this->getSelect()->__toString());
		if($this->_filter != null)
		{
			$this->getSelect()->where($this->_filter);
			//var_dump($this->getSelect()->__toString());
		}
		parent::load($printQuery, $logQuery);

	}
	
	/*
	public function getAvailableProducts()
	{
		$this->_select->reset()
	}
	*/
	
	
	
	//TODO: hat hier nichts verloren, sollte besser ins Model übertragen werden!!!!
	/**
	 * Verringert die verfügbare Menge des jeweiligen Produktes
	 *
	 * @param int $product_id
	 * @param int $qty
	 * @return false|array Bei Erfolg Array mit extstock_ids und zugehörigen Mengen array(id => integer, qty => integer)
	 */
	public function decreaseQuantityPerProduct($product_id, $qty, $stock_id) {
		if (!($product_id && $qty))
			return false;
		if ($qty <= 0) {
			Mage::log("extstock::Quantity must be greater zero!", Zend_Log::WARN, Slpb_Extstock_Helper_Data::LOG_FILE);
			return false;
		}
		
		if (!$stock_id) {
			Mage::log("extstock::stock_id not set!", Zend_Log::WARN, Slpb_Extstock_Helper_Data::LOG_FILE);
			return false;
		}
		
		if (!$product_id) {
			Mage::log("extstock::product_id not set!", Zend_Log::WARN, Slpb_Extstock_Helper_Data::LOG_FILE);
			return false;
		}
			
		$sql = "SELECT extstock_id,quantity FROM ".$this->getTable("extstock")." WHERE quantity > 0 AND product_id=".$product_id." AND stock_id=".$stock_id." ORDER BY `date_ordered`, `extstock_id`";
		$data = $this->getConnection()->fetchAll($sql);

		$errorMessage = "extstock::No product in store found to decrease stock value! [Product ID: $product_id;Quantity: $qty]";
		if (!is_array($data)) {
			Mage::log($errorMessage, Zend_Log::ALERT, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
			return false;
		}

		$itemsToDecrease = array();
		$handledQuantity = 0;
		//kleinste ID sollte immer zuerst drin stehen!
		foreach ($data as $row) {
			if (!is_array($row)) {
				Mage::log($errorMessage, Zend_Log::ALERT, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
				continue;
			}
			if (!array_key_exists("extstock_id", $row)) {
				Mage::log($errorMessage." 'extstock_id' key is missing!", Zend_Log::ALERT, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
				continue;
			}
			if (!array_key_exists("quantity", $row)) {
				Mage::log($errorMessage." 'quantity' key is missing!", Zend_Log::ALERT, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
				continue;
			}
			if ($handledQuantity >= $qty)
			break;

			if ($row["quantity"] >= $qty-$handledQuantity) {
				$itemsToDecrease[] = array(
					"id" => $row["extstock_id"]
				, "qty" => $qty-$handledQuantity
				);
				$handledQuantity += ($qty-$handledQuantity);
				break;
			} else {
				$itemsToDecrease[] = array(
					"id" => $row["extstock_id"]
				, "qty" => $row["quantity"]
				);
				$handledQuantity += $row["quantity"];
			}
		}

		if ($handledQuantity < $qty) {
			Mage::log("extstock::Not enough products found to decrease stock value! [Product ID: $product_id;Quantity: $qty]"
				, Zend_Log::ALERT
				, Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
			return false;
		}

		foreach ($itemsToDecrease as $item) {
			$sql = "UPDATE ".$this->getTable("extstock")." SET quantity=quantity-".$item["qty"]." WHERE extstock_id=".$item["id"];
			$this->getConnection()->query($sql);
		}

		return $itemsToDecrease;
	}
}