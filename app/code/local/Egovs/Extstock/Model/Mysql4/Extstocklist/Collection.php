<?php

class Egovs_Extstock_Model_Mysql4_Extstocklist_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	
	protected $_eventPrefix = 'extstock_list_collection';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'extstock_list_collection';
	

	public function _construct()
	{
		parent::_construct();
		$this->_init('extstock/extstock');
	}

	public function load($printQuery = false, $logQuery = false)
	{
		if ($this->isLoaded()) {
			return $this;
		}

		$sql = "(
			SELECT *,MIN(tbl1.price) AS cost_price, SUM(tbl1.quantity) AS total_quantity,SUM(tbl1.BestandpP) AS stock_value
				FROM (
	      			SELECT tbl2.*, att.value as name, e.sku, quantity * price AS BestandpP
					FROM ".$this->getTable("extstock")." AS tbl2
			        inner join ".(string)Mage::getConfig()->getTablePrefix()."catalog_product_entity e on tbl2.product_id = e.entity_id
			        inner join ".(string)Mage::getConfig()->getTablePrefix()."catalog_product_entity_varchar att on att.entity_id = e.entity_id
			        inner join ".$this->getTable('eav/attribute')." ea on att.attribute_id=ea.attribute_id
			        inner join ".$this->getTable('eav/entity_type')." et on ea.entity_type_id = et.entity_type_id
			        WHERE et.entity_type_code = 'catalog_product'
			        AND ea.attribute_code = 'name'
				) AS tbl1 GROUP BY product_id,distributor
			)";
		
		$this->getSelect()->reset(Zend_Db_Select::FROM)
						->reset(Zend_Db_Select::COLUMNS)
						->from(new Zend_Db_Expr($sql));
//		print($this->getSelect()->assemble());
							
		return parent::load($printQuery, $logQuery);
	}
	
	/**
	 * Tut nichts mehr.
	 * 
	 * @return $this
	 * @deprecated load hat diese Aufgabe übernommen
	 */
	public function addOrderedStockValue()
	{
		return $this;
	}
}