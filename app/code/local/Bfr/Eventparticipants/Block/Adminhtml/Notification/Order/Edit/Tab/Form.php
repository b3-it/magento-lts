<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package        Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Block_Adminhtml_Notification_Order_Edit_Tab_Form
 * @author        Holger Kögel <h.koegel@b3-it.de>
 * @copyright    Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license        http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Block_Adminhtml_Notification_Order_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('notificationorder_form', array('legend' => Mage::helper('bfr_eventparticipants')->__(' Notification Order information')));

        if (Mage::getSingleton('adminhtml/session')->getnotificationorderData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getnotificationorderData());
            Mage::getSingleton('adminhtml/session')->setnotificationorderData(null);
        } elseif (Mage::registry('notificationorder_data')) {
            $form->setValues(Mage::registry('notificationorder_data')->getData());
        }
        return parent::_prepareForm();
    }
}
