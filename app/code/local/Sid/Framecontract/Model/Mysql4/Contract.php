<?php

class Sid_Framecontract_Model_Mysql4_Contract extends Mage_Core_Model_Mysql4_Abstract
{
	

	
    public function _construct()
    {    
        // Note that the framecontract_contract_id refers to the key field in your database table.
        $this->_init('framecontract/contract', 'framecontract_contract_id');
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
    		->join(array('los' => $this->getTable('framecontract/los')),'main_table.value=los.los_id',array())
    		->where('attribute_id='.$eav)
    		->where('los.framecontract_contract_id='.intval($object->getId()));
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
    
    /**
     * am Produkt speichern om eine Mail über den Lagerbestand gesendet wurde
     * @param array $itemIds
     */
    public function saveItemsStockStatusSend(array $itemIds)
    {
    	if(count($itemIds) > 0)
    	{
    		$itemIds = implode(',', $itemIds);
	    	$write = $this->_getWriteAdapter();
	    	$write->update($this->getTable('catalog/product'), array('stock_status_send' => '1'),'entity_id IN ('.$itemIds.')');
    	}
    }

}