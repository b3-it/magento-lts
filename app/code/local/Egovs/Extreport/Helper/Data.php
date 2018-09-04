<?php

/**
 * Helper
 * 
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Extreport_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $_categoryNames = null;
	
	/**
	 * Liefert die Haushaltstelle als Option-Array
	 * 
	 * @return array
	 */
	public function getHaushaltsstelleAsOptionArray() {
		
		$collection = Mage::getModel('paymentbase/haushaltsparameter')->getCollection();
		$collection->getSelect()
            ->where('type='.Egovs_Paymentbase_Model_Haushaltsparameter_Type::HAUSHALTSTELLE)
            ->order('title');
		$res = array();
		foreach ($collection->getItems() as $item) {
	
			if (!isset($res[$item->getHaushaltsstelle()])) {
				$res[$item->getId()] = $item->getName();
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