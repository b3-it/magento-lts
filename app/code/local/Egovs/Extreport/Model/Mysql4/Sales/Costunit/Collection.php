<?php

/**
 * ResourceModel Collection für Kostenstelle
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Sales_Costunit_Collection extends Mage_Sales_Model_Mysql4_Order_Item_Collection
{
	protected $_categoryfilter = null;

	/**
	 * Fügt zu $val den optionalen Tabellenprefix hinzu
	 *
	 * @param string $val Tabellenname
	 *
	 * @return string
	 */
	protected function _getTablePrefix($val)
	{
		return Mage::getConfig()->getTablePrefix().$val;
	}

	/**
	 * Initialisiert das Select
	 *
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Costunit_Collection
	 *
	 * @see Mage_Core_Model_Mysql4_Collection_Abstract::_initSelect()
	 */
	protected function _initSelect()
	{
		parent::_initSelect();

		$isolation = false;
				
		if(Mage::helper('core')->isModuleEnabled('Egovs_Isolation'))
		{
			$helper  = Mage::helper('isolation');
			if(!$helper->getUserIsAdmin()){
				$isolation = true;
			}
		}
		if($isolation)
		{
			$helper  = Mage::helper('isolation'); 
			$sg = implode(',',$helper->getUserStoreGroups());
			
			$this->getSelect()
			->join(
					array('order'=>$this->getTable('sales/order')),
					"order.entity_id = main_table.order_id AND order.state <> 'canceled' AND store_group IN ({$sg}) ",
					array('order_date'=>'created_at', "state")
					)->joinLeft(
							array('e'=>$this->getTable('catalog/category_product')),
							'e.product_id = main_table.product_id',
							array('category_ids' => new Zend_Db_Expr("GROUP_CONCAT(DISTINCT CONCAT_WS(', ', category_id))"))
							)
							;
		
		} else {
			$this->getSelect()
				->join(
						array('order'=>$this->getTable('sales/order')),
						"order.entity_id = main_table.order_id AND order.state <> 'canceled'",
						array('order_date'=>'created_at', "state")
				)->joinLeft(
						array('e'=>$this->getTable('catalog/category_product')),
						'e.product_id = main_table.product_id',
						array('category_ids' => new Zend_Db_Expr("GROUP_CONCAT(DISTINCT CONCAT_WS(', ', category_id))"))
				)
			;
		}
        $this->getSelect()
            ->join(
                array('payment'=>$this->getTable('sales/order_payment')),
                "order.entity_id = payment.parent_id ",
                array("method"));
		
		
	
		
		/* @var $catalog Mage_Catalog_Model_Resource_Product */
		$catalog = Mage::getResourceSingleton('catalog/product');
		$kfr = array();
		$kfr[] = $catalog->getAttribute('kostenstelle');
		$kfr[] = $catalog->getAttribute('kostentraeger');
		$kfr[] = $catalog->getAttribute('haushaltsstelle');
		$kfr[]  = $catalog->getAttribute('objektnummer');
		$kfr[] = $catalog->getAttribute('objektnummer_mwst');
		
		foreach ($kfr as $attribute) {
			if (!$attribute) {
				continue;
			}
			$alias = sprintf('_left_%s', $attribute->getAttributeCode());
			$this->getSelect()
						->joinLeft(array($alias => $attribute->getBackendTable()),
						sprintf('%1$s.attribute_id = %2$s and %1$s.entity_id = main_table.product_id', $alias, $attribute->getAttributeId()),
						array($attribute->getAttributeCode() => 'value')
				)
			;			
		}
		
		$this->getSelect()
				->joinLeft(array('left_sale'=>$this->getTable('sales/order_item')),
						'left_sale.item_id = main_table.parent_item_id',
						array()
				)
                ->columns(array('sum_qty_ordered'=>'sum(`main_table`.`qty_ordered`)',
                                'sum_qty_ordered_base_row_total_incl_tax'=>'sum(`main_table`.`qty_ordered`)*main_table.base_row_total_incl_tax',
                                'sum_qty_ordered_base_row_total'=>'sum(`main_table`.`qty_ordered`)*main_table.base_row_total'))
                ->group('main_table.product_id')
				->group('main_table.order_id')
				->group('main_table.created_at')
		;
		//die($this->getSelect()->__toString());
		//Mage::log(sprintf('sql: %s', $this->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

		
		
		
		return $this;
	}

	/**
	 * Filtert nach der angegebenen Website des Stores
	 *
	 * @param integer $filter Store ID
	 *
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Costunit_Collection
	 */
	public function addWebsiteFilter($filter)
	{
		$filter = implode(',', $filter);
		$this->getSelect()->where('order.store_id in ('.$filter.')');
	}

	/**
	 * Filtert nach dem angegebenen Store
	 *
	 * @param integer $filter Store ID
	 *
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Costunit_Collection
	 */
	public function addStoreFilter($filter)
	{
		//var_dump($filter);
		$this->getSelect()->where('order.store_id = '.$filter);
	}
	
	
	protected function x_afterLoadData()
	{
		$hhCollection = Mage::getModel('paymentbase/haushaltsparameter')->getCollection();
		$hh = $hhCollection->getItems();
		
		foreach ($this->getItems() as $key => $item)
		{
			if(isset($hh[$item->getHaushaltsstelle()]))	$item->setHaushaltsstelle($hh[$item->getHaushaltsstelle()]->getValue());
			if(isset($hh[$item->getObjektnummer()])) $item->setObjektnummer($hh[$item->getObjektnummer()]->getValue());
			if(isset($hh[$item->getObjektnummerMwst()])) $item->setObjektnummerMwst($hh[$item->getObjektnummerMwst()]->getValue());
			$this->_items[$key] = $item;
		}
		
		return parent::_afterLoad();
	}
	
	
	/**
	 * Liefert die Anzahl der Ergbnisse
	 * 
	 * @return string
	 * 
	 * @see Varien_Data_Collection_Db::getSelectCountSql()
	 */
	public function getSelectCountSql()
	{
		$this->_renderFilters();

		$countSelect = clone $this->getSelect();
		$countSelect->reset(Zend_Db_Select::ORDER);
		$countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
		$countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
		//      $countSelect->reset(Zend_Db_Select::COLUMNS);
		//    	$countSelect->reset(Zend_Db_Select::WHERE);
		//    	$countSelect->reset(Zend_Db_Select::HAVING);
		$sql = new Zend_Db_Expr('select count(order_date) as cnt from ('.$countSelect->assemble().') as sub');
		return $sql;
	}
	/**
	 * Liefert diese Collection als Report
	 *
	 * Von/Bis Datum wird ignoriert
	 *
	 * @param string $from Von Datum
	 * @param string $to   Bis Datum
	 *
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Costunit_Collection
	 */
	public function getReportFull($from, $to)
	{
		return $this;
	}

	/**
	 * Setzt den Kategorienfilter
	 * 
	 * @param array $filter Filter
	 * 
	 * @return void
	 */
	public function setCategoryFilter($filter)
	{
		$this->_categoryfilter = $filter;
	}

	/**
	 * Wird vor dem Laden aufgerufen
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Costunit_Collection
	 */
	protected function _beforeLoad()
	{
		if (!empty($this->_categoryfilter)) {
			if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
				$this->getSelect()->where("FIND_IN_SET('".$this->_categoryfilter."',category_ids) > 0");
			} else {
				$this->getSelect()->having("FIND_IN_SET('".$this->_categoryfilter."',category_ids) > 0");
			}
		}	 
		 
		//die($this->getSelect()->__toString());
		return $this;
	}
	
	/**
	 * Lädt die Collection
	 * 
	 * Vor dem laden wird _beforeLoad() aufgerufen
	 * 
	 * @param boolean $printQuery Print?
	 * @param boolean $logQuery   Loggen?
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Costunit_Collection
	 * 
	 * @see Egovs_Extreport_Model_Mysql4_Sales_Costunit_Collection::_beforeLoad
	 * @see Mage_Core_Model_Mysql4_Collection_Abstract::load()
	 */
	public function load($printQuery = false, $logQuery = false)
	{
		$this->_beforeLoad();
		parent::load($printQuery, $logQuery);
	}

	/**
	 * Wird nach dem Laden aufgerufen
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Costunit_Collection
	 * 
	 * @see Mage_Sales_Model_Mysql4_Order_Item_Collection::_afterLoad()
	 */
	protected function _afterLoad()
	{		 
		foreach ($this->getItems() as $item) {
			$item->setData('category', $this->_getCategoryNames($item->getData('category_ids')));
		}
		 
		return parent::_afterLoad();
	}

	/**
	 * Liefert die Kategorienamen als String
	 * 
	 * Die Kategorien sind durch Kommata getrennt
	 * 
	 * @param string $ids Kategorien IDs
	 * 
	 * @return string
	 */
	protected function _getCategoryNames($ids) {		 
		return Mage::helper('extreport')->getCategoryNames($ids);
	}

	/**
	 * Liefert die Kategorien als Option-Array
	 *
	 * @return array
	 */
	public function getCategorysAsOptionArray() {
		return Mage::helper('extreport')->getCategorysAsOptionArray();
	}
}