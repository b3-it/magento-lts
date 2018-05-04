<?php
/**
 * B3it Subscription
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Model_Status
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Model_Renewalstatus extends Varien_Object
{
    const STATUS_PAUSE		= 1;
    const STATUS_REORDERD	= 2;
    const STATUS_EMAIL_SEND	= 3;
    const STATUS_ORDER_PENDING	= 4;
    const STATUS_ERROR	= 5;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_PAUSE    		=> Mage::helper('b3it_subscription')->__('Pause'),
            self::STATUS_REORDERD   	=> Mage::helper('b3it_subscription')->__('Reorderd'),
        	self::STATUS_EMAIL_SEND 	=> Mage::helper('b3it_subscription')->__('Email sent'),
        	self::STATUS_ORDER_PENDING=> Mage::helper('b3it_subscription')->__('Procesing'),
        	self::STATUS_ERROR=> Mage::helper('b3it_subscription')->__('Error')
        );
    }
}