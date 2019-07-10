<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package     Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Block_Notification_order
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Block_Adminhtml_Notification_Order extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_notification_order';
        $this->_blockGroup = 'bfr_eventparticipants';
        $this->_headerText = Mage::helper('bfr_eventparticipants')->__('Participationlist Agreements Manager');
        $this->_addButtonLabel = Mage::helper('bfr_eventparticipants')->__('Add Item');
        parent::__construct();
    }
}
