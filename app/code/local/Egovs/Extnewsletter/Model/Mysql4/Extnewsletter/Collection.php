<?php

class Egovs_Extnewsletter_Model_Mysql4_Extnewsletter_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('extnewsletter/extnewsletter');
    }
    
    public function addProductInfoToQuerry()
    {
    	$this->getSelect()
    	->joinLeft(array('cp'=>'catalog_product_entity_varchar'),'main_table.product_id=cp.entity_id',array('name'=> 'value'))
    	->joinLeft(array('e'=>'eav_attribute'),'e.attribute_id = cp.attribute_id',array())
    	->joinLeft(array('t'=>'eav_entity_type'),'t.entity_type_id = e.entity_type_id',array())
    	->where("((t.entity_type_code = 'catalog_product') AND (e.attribute_code = 'name') AND (cp.store_id = 0) OR (main_table.product_id=0))");
//die($this->getSelect()->__toString());		
    	return $this;
    }
    
  	public function addSubscriberId($subsciberId)
    {
    	$this->getSelect()
            //->from($this->_mainTable)
            ->where('subscriber_id=?',$subsciberId);

       return $this;
    }
    
    public function addOnlyActiveProductsFilter()
    {
    	$this->getSelect()
            //->from($this->_mainTable)
            ->where('is_active=1');
        return $this;
    }
}