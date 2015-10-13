<?php

class Egovs_Informationservice_Model_Task extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('informationservice/task');
    }
    
   
    public function getTotalCost($request_id)
    {
    	$collection = $this->getCollection();
    	$collection->getSelect()->where('request_id='.intval($request_id));

    	$res = 0;
    	foreach ($collection->getItems()  as $item) {
    		$res += $item->getCost(); 
    	}
    	return $res;
    }
    
 
    
    
}