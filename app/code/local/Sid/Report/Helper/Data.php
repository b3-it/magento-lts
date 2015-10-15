<?php

class Sid_Report_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $_categoryNames = null;
	
	/**
	 * Liefert die Haushaltstelle als Option-Array
	 *
	 * @return array
	 */
	public function getHaushaltsstelleAsOptionArray() {
		$collection = Mage::getModel('catalog/product')
		->getCollection()
		->addAttributeToSelect('haushaltsstelle')
		->addAttributeToSort('haushaltsstelle')
		;
		$res = array();
		foreach ($collection->getItems() as $item) {
			if (!isset($res[$item->getHaushaltsstelle()])) {
				$res[$item->getHaushaltsstelle()] = $item->getHaushaltsstelle();
			}
		}
		return $res;
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
	public function getCategoryNames($ids) {
		if ($this->_categoryNames == null) {
			$collection = Mage::getModel('catalog/category')
			->getCollection()
			->addAttributeToSelect('name')
			->setOrder('name', Varien_Data_Collection_Db::SORT_ORDER_ASC)
			->load();
			$this->_categoryNames = array();
				
			foreach ($collection->getItems() as $item) {
				$this->_categoryNames[$item->getData('entity_id')]= $item->getData('name');
			}
	
		}
			
		$catIds = explode(',', $ids);
		$res = array();
		foreach ($catIds as $id) {
			if (strlen($id) > 0
			&& is_array($this->_categoryNames)
			&& array_key_exists($id, $this->_categoryNames)
			) {
				$res[] = $this->_categoryNames[$id];
			}
		}
		return implode(', ', $res);
	}
	
	/**
	 * Liefert die Kategorien als Option-Array
	 *
	 * @return array
	 */
	public function getCategorysAsOptionArray() {
		$collection = Mage::getModel('catalog/category')
		->getCollection()
		->addAttributeToSelect('name')
		->setOrder('name', Varien_Data_Collection_Db::SORT_ORDER_ASC)
		->load();
		$res = array();
		foreach ($collection->getItems() as $item) {
			if ($item->getData('level')+0 > 0) {
				$res[$item->getData('entity_id')] = $item->getData('name');
			}
		}
		return $res;
	}
}