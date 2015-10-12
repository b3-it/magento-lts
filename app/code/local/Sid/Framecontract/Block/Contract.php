<?php
class Sid_Framecontract_Block_Contract extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getFramecontract()     
     { 
        if (!$this->hasData('contract')) {
            $this->setData('contract', Mage::registry('contract'));
        }
        return $this->getData('contract');
        
    }
}