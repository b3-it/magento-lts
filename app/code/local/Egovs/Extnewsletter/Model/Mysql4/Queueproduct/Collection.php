<?php

class Egovs_Extnewsletter_Model_Mysql4_Queueproduct_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('extnewsletter/queueproduct');
    }
    
    public function getCountByQueueId($queueid)
    {
    	$select = $this->getSelect();
    	$select->where('queue_id='.$queueid);
    	$collection = $this->load()->getItems();
    	if($collection == null) return 0;
    	
    	return count($collection);
    }
    
	public function getProductsForQueue($queue)
	{
		$res = array();
		if($queue == null) return $res;
		$select = $this->getSelect();
    	$select->where('queue_id='.$queue);
    	$collection = $this->load()->getItems();
    	if($collection == null) return $res;
    	foreach($collection as $item)
    	{
    		$res[] = $item->getData('product_id');
    	}
    	
    	
    	return $res;
	}
}