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
class B3it_Subscription_Model_Status extends Varien_Object
{
    const STATUS_ACTIVE	= 1;
    const STATUS_DELETE		= 2;
    const STATUS_CANCELED	= 3;
    const STATUS_EXPIRED	= 4;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ACTIVE    => Mage::helper('b3it_subscription')->__('Active'),
            self::STATUS_DELETE   => Mage::helper('b3it_subscription')->__('Deleted'),
        	self::STATUS_CANCELED   => Mage::helper('b3it_subscription')->__('Resigned'),
        	self::STATUS_EXPIRED   => Mage::helper('b3it_subscription')->__('Expired')
        );
    }
}