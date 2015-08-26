<?php

class Dwd_Stationen_Model_Derivation extends Mage_Core_Model_Abstract
{
	
	protected $_eventPrefix = 'stationen';
    protected $_eventObject = 'derivation';
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('stationen/derivation');
    }
    
    public function updateCategoryRelation($categories)
    {
    	$this->getResource()->updateCategoryRelation($this->getId(),$categories);
    	return $this;
    }
    
    public function loadCategoryRelation()
    {
     	$this->getResource()->loadCategoryRelation($this);
    	return $this;
    }
    
}