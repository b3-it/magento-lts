<?php
/**
 * Bfr EventRequest
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Block_Request
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Block_Request extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getEventRequest()     
     { 
        if (!$this->hasData('request')) {
            $this->setData('request', Mage::registry('request'));
        }
        return $this->getData('request');
        
    }
}