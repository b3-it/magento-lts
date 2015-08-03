<?php

class Egovs_Extnewsletter_Model_Mysql4_Queueissue_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('extnewsletter/queueissue');
    }
    
    public function getCountByQueueId($queueid)
    {
    	$select = $this->getSelect();
    	$select->where('queue_id='.$queueid);
    	$collection = $this->load()->getItems();
    	if($collection == null) return 0;
    	
    	return count($collection);
    }
    
	
}