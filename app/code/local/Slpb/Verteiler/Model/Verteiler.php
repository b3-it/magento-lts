<?php

class Slpb_Verteiler_Model_Verteiler extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('verteiler/verteiler');
    }
    
    public function getCustomers()
    {
    	
    	if($this->getId())
    	{
	    	$collection = Mage::getModel('verteiler/verteiler_customer')->getCollection();
	     	$collection->getSelect()
     			->where('verteiler_id=?', intval($this->getId()));
     			
     		$res = array(); 
     		foreach($collection->getItems() as $item)
     		{
     			$res[$item->getCustomerId()] = $item;
     		}	
     		return $res;  
    	}
    	
    	return null; 	
    }
    
  	public function updateCustomerRelation($selected,$deleted)
    {
    	$this->getResource()->updateCustomerRelation($this->getId(),$selected,$deleted);
    	return $this;
    }
}