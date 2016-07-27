<?php

class Sid_Framecontract_Model_Mysql4_Los extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the framecontract_contract_id refers to the key field in your database table.
        $this->_init('framecontract/los', 'los_id');
    }
    
    
    public function getProductIds($object)
    {
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	$eav = $eav->getIdByCode('catalog_product', 'framecontract_los');
    	$values = array();
     	$read = $this->_getReadAdapter();
        if ($read) {
        	$select = new Zend_Db_Select($read);
            $select
            	->from(array('main_table' => $this->getTable('catalog/product').'_int', array('entity_id')))
            	->where('attribute_id='.$eav)
            	->where('value='.intval($object->getId()));
            $data = $read->fetchAll($select);
			
            if ($data) 
            {
	           	
	           	 foreach($data as $d){
	           	 	$values[] = $d['entity_id'];
	        	}
           		
            }
        }
        
        return $values;
    }
    
    
    public function loadByProductId($object,$productId)
    {
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	$eav = $eav->getIdByCode('catalog_product', 'framecontract_los');
    	 
    	$read = $this->_getReadAdapter();
    	if ($read && !is_null($productId)) {
    		$select = $this->_getReadAdapter()->select()
    		->join(array('product' => $this->getTable('catalog/product').'_int'),'product.value = framecontract_los.los_id AND product.attribute_id ='.$eav , array())
    		->from($this->getMainTable())
    		->where('product.entity_id = ?', $productId);
    		$data = $read->fetchRow($select);
    		 
    		if ($data) {
    			$object->setData($data);
    		}
    	}
    	 
    	$this->unserializeFields($object);
    	$this->_afterLoad($object);
    	 
    	return $this;
    }
}