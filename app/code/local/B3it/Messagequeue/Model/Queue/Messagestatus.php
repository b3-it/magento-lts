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
    const STATUS_PROCESSING	= 1;
    const STATUS_FINISHED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_NEW        => Mage::helper('b3it_mq')->__('New'),
            self::STATUS_PROCESSING    => Mage::helper('b3it_mq')->__('Processing'),
            self::STATUS_FINISHED   => Mage::helper('b3it_mq')->__('Finished')
        );
    }
}