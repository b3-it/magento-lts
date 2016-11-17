<?php

class Dwd_Periode_Model_Mysql4_Periode_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	
	private $_StoreId = null;
	
	
	public function setStoreId($storeID)
	{
		$this->_StoreId = $storeID;
	} 
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('periode/periode');
    }
    
     protected function _beforeLoad()
     {
     	parent::_beforeLoad();
     	if($this->_StoreId){
     		$this->getSelect()->joinLeft(array('store_label'=>$this->getTable('periode/store_label')),
     						'main_table.entity_id = store_label.periode_id AND store_label.store_id ='.intval($this->_StoreId),
     						array('store_label'=>'store_label.label','store_id'=>'store_label.store_id'));
     	}
     }
    
}