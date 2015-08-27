<?php

class Dwd_Stationen_Model_Set extends Mage_Core_Model_Abstract
{
	
	protected $_eventPrefix = 'stationen';
    protected $_eventObject = 'set';
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('stationen/set');
    }
    
   public function updateSetStationRelation($stationen_ids,$deleteStations)
    {
    	$this->getResource()->updateSetStationRelation($this->getId(),$stationen_ids,$deleteStations);
    	return $this;
    }
    
    public function getStationen()
    {
    	if($this->getId())
    	{
	    	$collection = Mage::getModel('stationen/stationen')->getCollection();
	        $collection->addAttributeToSelect('*');
	     	$collection->getSelect()
	     		->distinct()
     			->join(array('relation'=>'stationen_set_relation'),'relation.stationen_id = e.entity_id AND set_id='.$this->getId(),array());
   			
     		$res = array();
     		foreach($collection->getItems() as $item)
     		{
     			$res[$item->getId()] = $item;
     		}	
     		return $res;
    	}
    	
    	return null;
    	
    }
    
    public function updateSetProductRelation($products,$deleteProducts)
    {
    	foreach($deleteProducts as $productId)
    	{
    		$product = Mage::getModel('catalog/product')->load($productId);
    		if($product->getId())
    		{
    			$product->setStationenSet(0)->save();
    		}
    	}
       	
    	foreach($products as $productId)
    	{
    		$product = Mage::getModel('catalog/product')->load($productId);
    		if($product->getId())
    		{
    			$product->setStationenSet($this->getId())->save();
    		}
    	}
    }
    protected function _beforeDelete()
    {
    	$count = 0;
	  	$collection = Mage::getModel('catalog/product')->getCollection();
	  	if($this->getId())
	  	{
	  		$collection->addAttributeToFilter('stationen_set',$this->getId());	
	  		$count = count($collection->getItems());
	  	}
	  	
	  	if($count > 0)
	  	{
	  		Mage::throwException(Mage::helper('stationen')->__('Set %s still has assigned products.',$this->getId()));
	  	}
    	
    	
    	return parent::_beforeDelete();
    }
}