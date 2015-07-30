<?php
/**
 * ResourceModel Collection für Kassenzeichen
 *
 * <strong>Achtung</strong>
 * Nicht zu Magento 1.3 kompatibel
 * 
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Sales_Kassenzeichen_Collection extends Mage_Sales_Model_Resource_Order_Collection
{
	/**
	 * Liefert die Anzahl der Treffer
	 * 
	 * @return Varien_Db_Select
	 * 
	 * @see Mage_Sales_Model_Resource_Order_Collection::getSelectCountSql()
	 */
	public function getSelectCountSql() {		
		$this->_renderFilters();
		
		$select = clone $this->getSelect();
		$select->reset(Zend_Db_Select::ORDER);
		$select->reset(Zend_Db_Select::LIMIT_COUNT);
		$select->reset(Zend_Db_Select::LIMIT_OFFSET);
		
		$countSelect = new Varien_Db_Select($this->getConnection());
		$countSelect->from(new Zend_Db_Expr(sprintf('(%s)', $select->assemble())));		
		$countSelect->reset(Zend_Db_Select::COLUMNS);
		
		$countSelect->columns('COUNT(*)');
		
		return $countSelect;
	}
}