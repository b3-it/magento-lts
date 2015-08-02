<?php
class Egovs_Extnewsletter_Block_Extnewsletter extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getExtnewsletter()     
     { 
        if (!$this->hasData('extnewsletter')) {
            $this->setData('extnewsletter', Mage::registry('extnewsletter'));
        }
        return $this->getData('extnewsletter');
        
    }
}