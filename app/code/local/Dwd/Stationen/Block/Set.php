<?php
class Dwd_Stationen_Block_Set extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getStationen()     
     { 
        if (!$this->hasData('set')) {
            $this->setData('set', Mage::registry('set'));
        }
        return $this->getData('set');
        
    }
}