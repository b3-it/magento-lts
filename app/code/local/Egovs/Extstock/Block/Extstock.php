<?php
class Egovs_Extstock_Block_Extstock extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getExtstock()     
     { 
        if (!$this->hasData('extstock')) {
            $this->setData('extstock', Mage::registry('extstock'));
        }
        return $this->getData('extstock');
        
    }
}