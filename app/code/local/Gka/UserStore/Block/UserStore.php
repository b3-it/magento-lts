<?php
class Gka_UserStore_Block_UserStore extends Mage_Core_Block_Template
{
	protected $_customer = null;
	
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
   
   protected function _getCustomer()
    {
    	if($this->_customer == null){
    		$this->_customer = Mage::getSingleton('customer/session')->getCustomer();
    	}
    	return $this->_customer;
    }
    
    public function getCustomerId()
    {
    	$customer = $this->_getCustomer();
    	if($customer)
    	{
    		return $customer->getId();
    	}
    	
    	return 0;
    }
    
    public function getStoresAllowed()
    {
    	$store_ids = $this->getCustomer()->getAllowedStores();
    	$res = array();
    	
    	$stores = Mage::app()->getStores();
    	
    	foreach($stores as $store)
    	{
    		//if()
    	}
    	
    	return $res;	
    }
}