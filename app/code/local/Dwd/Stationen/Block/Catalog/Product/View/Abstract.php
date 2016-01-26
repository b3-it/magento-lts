<?php
class Dwd_Stationen_Block_Catalog_Product_View_Abstract extends Mage_Catalog_Block_Product_View_Abstract
{
	
	protected $_StationsList = null;
    
	
	
    protected function getStationsList()
    {
    	if($this->_StationsList == null)
    	{
    		
    		$set_id = $this->getProduct()->getStationenSet();
    		if( !$set_id) {$set_id = 0;}
    		$this->_StationsList = array();
    		$collection = Mage::getModel('stationen/stationen')->getCollection();
    		$collection->addAttributeToSelect('*')->setOrder('name');
    		$collection->getSelect()
    				->distinct()
	    			->join(array('set'=>'stationen_set_relation'),'set.stationen_id = e.entity_id',array())
	    			->where('set_id = ?', $set_id)
	    			;
			$set = Mage::getModel('stationen/set')->load($set_id);
			
			if($set->getShowActiveOnly())
			{
				$collection->getSelect()
    				->where('status = ' . Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE)
	    			;
			}
	    	
    		foreach ($collection->getItems() as $item)
    		{
    			$stations_ids[] = $item->getId();
    			$this->_StationsList[$item->getId()] = $item;
    		}
    		
    	}
    	
    	return $this->_StationsList; 
    }
    
   	public function hasStationen()
   	{
   		return count($this->getStationsList()) > 0;
   	}
    
    
}