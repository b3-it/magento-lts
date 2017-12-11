<?php

/**
 * ResourceModel Collection für Gewinn
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Sales_Revenue_Collection extends Mage_Sales_Model_Mysql4_Order_Item_Collection
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
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Revenue_Collection
	 *
	 * @see Mage_Core_Model_Mysql4_Collection_Abstract::_initSelect()
	 */
	protected function _initSelect()
	{
		parent::_initSelect();

		if(Mage::helper('core')->isModuleEnabled('extstock'))
		{
		$table = $this->getTable('extstock/salesorder');
		$expr = new Zend_Db_Expr("(
				SELECT DISTINCT
					sum(extorder.qty_ordered) as sub_qty,
					sum(extstock.price * extorder.qty_ordered) as sub_ek,
					extstock.product_id as productid,
					extorder.sales_order_id as orderid
				FROM ".$this->getTable('extstock/salesorder')." AS `extorder`
				INNER JOIN `".$this->getTable('extstock/extstock')."` AS extstock ON extstock.extstock_id = extorder.extstock_id
				GROUP BY extorder.sales_order_id, extstock.product_id
		)");

		$this->getSelect()
			->distinct()
			->columns(array(
					'vk_sum'=>'sum(IF(main_table.parent_item_id IS NULL, main_table.price * sub_qty , left_sale.price * sub_qty))',
					'yield'=>'sum(IF(main_table.parent_item_id IS NULL, (main_table.price * sub_qty)- sub_ek , (left_sale.price * sub_qty)-sub_ek))',
					'ek_sum'=>'sum(sub_ek)')
				)->join(array('extview' => $expr),
						'main_table.product_id = extview.productid and extview.orderid = main_table.order_id'
				)
		;
		}else{
			$this->getSelect()
			->distinct()
			->columns(array(
					'vk_sum'=>'sum(IF(main_table.parent_item_id IS NULL, main_table.price * sub_qty , left_sale.price * sub_qty))',
					'yield'=>'sum(IF(main_table.parent_item_id IS NULL, (main_table.price * sub_qty)- sub_ek , (left_sale.price * sub_qty)-sub_ek))',
					'ek_sum'=>'sum(sub_ek)')
					);
		}
		
		if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
			$att = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('order', 'state');
			
			$this->getSelect()
					->join(array('order' => $this->getTable('sales/order')),
							'order.entity_id = main_table.order_id',
							array('store_id'=>'store_id','order_date'=>'created_at')
					)->join(array('order_state'=> $this->_getTablePrefix('sales_order_varchar')),
							"order.entity_id = order_state.entity_id AND order_state.attribute_id='".$att."'  AND order_state.value<>'canceled'",
							array('bestellstatus'=>'order_state.value')
					)->joinLeft(array('e'=>$this->_getTablePrefix('catalog_product_entity')),
							'e.entity_id = main_table.product_id',
							array('category_ids'=>'category_ids')
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
				->joinLeft(array('left_sale'=>$this->getTable('sales/order_item')),
						'left_sale.item_id = main_table.parent_item_id',
						array()
				)->group('main_table.product_id')
				->group('main_table.order_id')
				->group('main_table.created_at')
		;
		
		Mage::log(sprintf('sql: %s', $this->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

		return $this;
	}

	/**
	 * Filtert nach der angegebenen Website des Stores
	 *
	 * @param integer $filter Store ID
	 *
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Revenue_Collection
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
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Revenue_Collection
	 */
	public function addStoreFilter($filter)
	{
		//var_dump($filter);
		$this->getSelect()->where('order.store_id = '.$filter);
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
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Revenue_Collection
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
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Revenue_Collection
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
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Revenue_Collection
	 * 
	 * @see Egovs_Extreport_Model_Mysql4_Sales_Revenue_Collection::_beforeLoad
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
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Revenue_Collection
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