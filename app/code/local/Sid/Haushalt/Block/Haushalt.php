<?php
class Sid_Haushalt_Block_Haushalt extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getHaushalt()     
     { 
        if (!$this->hasData('haushalt')) {
            $this->setData('haushalt', Mage::registry('haushalt'));
        }
        return $this->getData('haushalt');
        
    }
}