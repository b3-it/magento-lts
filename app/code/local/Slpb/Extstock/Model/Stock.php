<?php

class Slpb_Extstock_Model_Stock extends Mage_Core_Model_Abstract
{
	const STORETYP_LOSS = 1;
	const STORETYP_SOURCE = 2;
	const STORETYP_DESTINATION = 3;
	const STORETYP_UNIVERSAL = 4;
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('extstock/stock');
    }
    
    public function getIsLoss($id)
    {
    	$this->load($id);
    	if($this->getType() == Slpb_Extstock_Model_Stock::STORETYP_LOSS) return true;
    	return false;
    }

    public static function getTypeOptionsArray()
    {
    	return array(Slpb_Extstock_Model_Stock::STORETYP_LOSS => 'Loss',
    				Slpb_Extstock_Model_Stock::STORETYP_SOURCE => 'Source',
					Slpb_Extstock_Model_Stock::STORETYP_DESTINATION => 'Destination',
					Slpb_Extstock_Model_Stock::STORETYP_UNIVERSAL => 'Universal'
    	);
    }
    
    public function getSourceStockAsOptionsArray()
    {
 
    	$res = array();	
    	foreach($this->getCollection()->getItems() as $item)
    	{
    		$t = $item->getType();
    		if(($t == Slpb_Extstock_Model_Stock::STORETYP_SOURCE) ||
    			($t == Slpb_Extstock_Model_Stock::STORETYP_UNIVERSAL))
    			{
    				$res[$item->getId()]=$item->getName();
    			}
    	}
    	
    	return $res;
    }
    
    public function getDestinationStockAsOptionsArray()
    {
 
    	$res = array();	
    	foreach($this->getCollection()->getItems() as $item)
    	{
    		$t = $item->getType();
    		if(($t == Slpb_Extstock_Model_Stock::STORETYP_LOSS) ||
    			($t == Slpb_Extstock_Model_Stock::STORETYP_DESTINATION)||
    			($t == Slpb_Extstock_Model_Stock::STORETYP_UNIVERSAL))
    			{
    				$res[$item->getId()]=$item->getName();
    			}
    	}
    	
    	return $res;
    }
    
   public function getInputStockAsOptionsArray()
    {

    	$res = array();	
    	foreach($this->getCollection()->getItems() as $item)
    	{
    		$t = $item->getType();
    		if(($t != Slpb_Extstock_Model_Stock::STORETYP_LOSS))
    			{
    				$res[$item->getId()]=$item->getName();
    			}
    	}
    	
    	return $res;
    }

 
    public function toOptionArray()
    {
       
        
        $res = array();	
    	foreach($this->getCollection()->getItems() as $item)
    	{
    		$t = $item->getType();
    		if(($t != Slpb_Extstock_Model_Stock::STORETYP_LOSS))
    			{
    				$res[]= array('value'=>$item->getId(), 'label'=>$item->getName());
    			}
    	}
    	
    	return $res;
    }
    
}