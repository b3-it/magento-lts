<?php

class Sid_Framecontract_Model_Vendor extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('framecontract/vendor');
    }
    
    public function toSelectArray()
    {
    	$res = array();
    	foreach($this->getResourceCollection()->getItems() as $item)
    	{
    		$res[] = array('label'=>$item->getCompany(),'value'=>$item->getId());
    	}
    	return $res;
    }
    
    public function toOptionArray()
    {
    	$res = array();
    	foreach($this->getResourceCollection()->getItems() as $item)
    	{
    		$res[$item->getId()] = $item->getCompany();
    	}
    	return $res;
    }
    
 
}