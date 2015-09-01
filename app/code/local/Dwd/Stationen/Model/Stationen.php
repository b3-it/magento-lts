<?php

class Dwd_Stationen_Model_Stationen extends Mage_Core_Model_Abstract
{
	protected $_eventPrefix = 'stationen';
    protected $_eventObject = 'stationen';
    
    public function _construct()
    {
        parent::_construct();
        $this->_init('stationen/stationen');
    }
    
    public function updateSetStationRelation($new, $delete)
    {
    	$this->getResource()->updateSetStationRelation($this->getId(),$new, $delete);
    	return $this;
    }
    
    public function removeSetStationRelation()
    {
    	$this->getResource()->removeSetStationRelation($this->getId());
    	return $this;
    }
    
}