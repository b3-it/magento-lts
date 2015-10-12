<?php

/**
 * ResourceModel Collection für Gewicht versendeter Waren
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Extreport_Model_Mysql4_Sales_Weight_Collection extends Mage_Sales_Model_Mysql4_Order_Collection
{
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
	 * Fügt die Gewichtsinformationen hinzu
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Weight_Collection
	 */
	public function addWeight()
	{
		$expr = new Zend_Db_Expr(sprintf("(
					SELECT items.order_id, SUM(items.weight * items.qty_ordered) as weight
					FROM %s AS `items`
					GROUP BY items.order_id)",
					$this->getTable('sales/order_item')
				)
		);

		if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
			$this->getSelect()
				->join(array('t1'=>$expr), 't1.order_id=e.entity_id', array('weight'=>'weight'));
		} else {
			$this->getSelect()
				->join(array('t1'=>$expr), 't1.order_id=entity_id', array('weight'=>'weight'));
		}
		//die($this->getSelect()->__toString());
		return $this;
	}

	/**
	 * Initialisiert das Select
	 *
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Weight_Collection
	 *
	 * @see Mage_Core_Model_Mysql4_Collection_Abstract::_initSelect()
	 */
	protected function _initSelect()
	{
		parent::_initSelect();

		if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
			$att = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('order', 'state');
			$this->getSelect()
				->join(array('order_state'=> $this->_getTablePrefix('sales_order_varchar')),
						"e.entity_id = order_state.entity_id AND order_state.attribute_id='".$att."'",
						array('bestellstatus'=>'order_state.value')
				)
			;
		} else {
			$this->getSelect()->columns(array('bestellstatus' => 'state'));
		}
		
		Mage::log(sprintf('sql: %s', $this->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

		return $this;
	}
	/**
     * Setzt den StoreFilter der Collection
     *
     * @param array $storeIds Store IDs
     *
     * @return Egovs_Extreport_Model_Mysql4_Sales_Quantity_Collection
     */
	public function setStoreIds($storeIds)
	{
		$vals = array_values($storeIds);
		if (count($storeIds) >= 1 && $vals[0] != '') {
			$this->addFieldToFilter('store_id', array('in' => (array)$storeIds));
		}

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
		$this->getSelect()->where('store_id in ('.$filter.')');
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
		$this->getSelect()->where('store_id = '.$filter);
	}

}