<?php

class Slpb_Extstock_Model_Mysql4_Journal_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

	public function _construct()
	{
		parent::_construct();
		$this->_init('extstock/journal');
	}


	protected function _initSelect()
	{
		parent::_initSelect();
		$select = $this->getSelect()

		->join(array('e'=>(string)Mage::getConfig()->getTablePrefix().'catalog_product_entity'),'main_table.product_id = e.entity_id',array('sku'))
		->join(array('att'=>(string)Mage::getConfig()->getTablePrefix().'catalog_product_entity_varchar'),'att.entity_id = main_table.product_id',array('productname'=>'value'))
		->join(array('ea'=>$this->getTable('eav/attribute')),'att.attribute_id=ea.attribute_id',array())
		->join(array('et'=>$this->getTable('eav/entity_type')),'ea.entity_type_id = et.entity_type_id',array())
		->where("et.entity_type_code = 'catalog_product'")
		->where("ea.attribute_code = 'name'");
		
		//die($select->__toString());
		
	}
}