<?php
class B3it_Pendelliste_Block_Pendelliste extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getPendelliste()     
     { 
        if (!$this->hasData('pendelliste')) {
            $this->setData('pendelliste', Mage::registry('pendelliste'));
        }
        return $this->getData('pendelliste');
        
    }
}