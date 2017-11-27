<?php
class Gka_Reports_Block_Reports extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getReports()     
     { 
        if (!$this->hasData('reports')) {
            $this->setData('reports', Mage::registry('reports'));
        }
        return $this->getData('reports');
        
    }
}