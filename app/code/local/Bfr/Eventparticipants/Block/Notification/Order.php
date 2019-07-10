<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package     Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Block_Notification_Order
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Block_Notification_Order extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return int
     */
    public function getValidHash()
    {
        return Mage::registry('participationlist_agreement_hash');
    }
}
