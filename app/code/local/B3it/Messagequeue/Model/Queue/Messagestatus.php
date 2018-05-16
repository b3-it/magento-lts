<?php

/**
 * 
 *  Status der Regel
 *  @category B3it
 *  @package  B3it_Messagequeue_Model_Queue_Status
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Queue_Messagestatus extends Varien_Object
{
    const STATUS_NEW	= 0;
    const STATUS_ENABLED	= 1;
    const STATUS_DISABLED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_NEW        => Mage::helper('b3it_mq')->__('New'),
            self::STATUS_ENABLED    => Mage::helper('b3it_mq')->__('Enabled'),
            self::STATUS_DISABLED   => Mage::helper('b3it_mq')->__('Disabled')
        );
    }
}