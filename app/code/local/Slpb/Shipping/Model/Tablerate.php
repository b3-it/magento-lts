<?php

class Slpb_Shipping_Model_Tablerate extends Mage_Core_Model_Abstract
{

	const SHIPPING = 0;
	const PICKUP = 1;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('slpbshipping/tablerate');
        //$this->getCollection()->setConnection($this->getResource()->getReadConnection());
    }
    

    public function getRate($stars, $modul_id)
    {
    	$this->getCollection()
    		->setShipmoduleFilter($modul_id);
    	
    	$cost = 0;
    	$price = 0;
    	foreach ($this->getCollection()->getItems() as $item){
    		$cost = $item->getCost();
    		$price = $item->getPrice();
    		if(($item->getStar() == $stars)&&($item->getModul()== $modul_id)){
    			break;
    		}
    	}
    	
    	return array('price'=>$price,'cost'=>$cost);
    }
  
}