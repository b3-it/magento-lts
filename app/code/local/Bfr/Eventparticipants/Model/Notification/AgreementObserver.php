<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package     Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Model_Notification_Order
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Model_Notification_AgreementObserver extends Mage_Core_Model_Abstract
{
    /**
     * Product gets added to the shopping cart
     *
     * @param $observer
     */
    public function AfterCartAddProduct($observer)
    {

    }

    /**
     * Product gets edited while in the shopping cart
     *
     * @param $observer
     */
    public function AfterCardEditProduct($observer)
    {

    }

    /**
     * Product gets removed from the shopping cart (kein event in magento?)
     *
     * @param $observer
     */
    public function AfterCartRemoveProduct($observer)
    {

    }
}
