<?php
class Dwd_Stationen_Block_Catalog_Product_View_Abstract extends Mage_Catalog_Block_Product_View_Abstract
{
	
	protected $_StationsList = null;
    
	
	
    protected function getStationsList()
    {
    	if($this->_StationsList == null)
    	{
    	    /**
    	     * @var Dwd_Stationen_Helper_Data $helper
    	     */
    	    $helper = Mage::helper("stationen");
    	    $this->_StationsList = $helper->getStationsList($this->getProduct());
    	}
    	
    	return $this->_StationsList; 
    }
    
   	public function hasStationen()
   	{
   		return count($this->getStationsList()) > 0;
   	}
    
    
}