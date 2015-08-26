<?php
class Dwd_Stationen_Block_Stationen extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getStationen()     
     { 
        if (!$this->hasData('stationen')) {
            $this->setData('stationen', Mage::registry('stationen'));
        }
        return $this->getData('stationen');
        
    }
    
    
    
   
}