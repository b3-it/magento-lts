<?php

class Sid_Roles_Model_Customergroups extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sidroles/customergroups');
    }
    
    public function loadByCustomerGroup_User($CustomerGroupId, $UserId)
    {
    	
        $this->_getResource()->loadByCustomerGroup_User($this, $CustomerGroupId, $UserId);
        $this->_afterLoad();
        $this->setOrigData();
        $this->_hasDataChanges = false;
        
        //if($this->getId()) return null;
        
        return $this;
    }
    
    public function getCustomerGroupCountByUser($UserId)
    {
    	$collection = $this->getCollection();
    	$collection->getSelect()
    		->where("main_table.write=1")
    		->where('user_id='.$UserId);
    	//die($collection->getSelect()->__toString());
        return count($collection->getItems());
    }
}