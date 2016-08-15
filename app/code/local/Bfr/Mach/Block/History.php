<?php
/**
 * Bfr Mach
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Block_History
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Block_History extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getMach()     
     { 
        if (!$this->hasData('history')) {
            $this->setData('history', Mage::registry('history'));
        }
        return $this->getData('history');
        
    }
}