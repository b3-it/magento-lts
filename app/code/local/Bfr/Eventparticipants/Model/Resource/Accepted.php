<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package     Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Model_Resource_Accepted
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Model_Resource_Accepted extends Varien_Object
{
    const STATUS_PRIVATE = 0;
    const STATUS_REQUESTED = 1;
    const STATUS_PUBLIC = 2;

    /**
     * @return array
     */
    static public function getOptionArray()
    {
        return array(
            self::STATUS_PRIVATE => Mage::helper('bfr_eventparticipants')->__('Private'),
            self::STATUS_REQUESTED => Mage::helper('bfr_eventparticipants')->__('Requested'),
            self::STATUS_PUBLIC => Mage::helper('bfr_eventparticipants')->__('Public'),
        );
    }
}