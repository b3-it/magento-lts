<?php
/**
 * B3it Subscription
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Block_Subscription
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Block_Subscription extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getSubscription()
     { 
        if (!$this->hasData('subscription')) {
            $this->setData('subscription', Mage::registry('subscription'));
        }
        return $this->getData('subscription');
        
    }
}