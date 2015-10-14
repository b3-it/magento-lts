<?php

class Egovs_Extnewsletter_Model_Mysql4_Issue_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	
	/**
	 * Name prefix of events that are dispatched by model
	 *
	 * @var string
	 */
	protected $_eventPrefix = 'extnewsletter_issue_collection';
	
	/**
	 * Name of event parameter
	 *
	 * @var string
	 */
	protected $_eventObject = 'extnewsletter_issue_collection';
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('extnewsletter/issue');
    }
    
    /**
     * alle Themen des Stores und Themen f�r alle Stores (StoreId=0)
     * Enter description here ...
     * @param $store_id
     */
    public function addStoreOrAllFilter($store_id)
    {
    	if(is_array($store_id))
    	{
    		$store_id = implode(",", $store_id);
    	}
    	if(strlen($store_id)>0){
    		$this->getSelect()->where("store_id in (".$store_id . ") or store_id=0");
    	}else {
    		$this->getSelect()->where("store_id=0");
    	}
    	return $this;
    }
    
    
 
    
}