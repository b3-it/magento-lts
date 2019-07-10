<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package     Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Block_Adminhtml_Notification_Order_Edit_Tabs
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Block_Adminhtml_Notification_Order_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('notificationorder_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('bfr_eventparticipants')->__('Participationlist Agreement'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label' => Mage::helper('bfr_eventparticipants')->__('General'),
            'title' => Mage::helper('bfr_eventparticipants')->__('General'),
            'content' => $this->getLayout()->createBlock('bfr_eventparticipants/adminhtml_notification_order_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
