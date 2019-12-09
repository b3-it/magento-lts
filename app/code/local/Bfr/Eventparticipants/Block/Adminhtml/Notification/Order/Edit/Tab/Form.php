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

        if (Mage::registry('notificationorder_data')) {

            /** @var Bfr_Eventparticipants_Model_Notification_Order $agreement */
            $agreement = Mage::registry('notificationorder_data');

            try {
                $orderItem = Mage::getModel('sales/order_item')->load($agreement->getOrderItemId());
                $order = Mage::getModel('sales/order')->load($orderItem->getOrderId());
                $event = Mage::getModel('eventmanager/event')->load($agreement->getEventId());

                $fieldset->addField('order', 'text', array(
                    'label' => Mage::helper('bfr_eventparticipants')->__('Order'),
                    'class' => 'readonly disabled',
                    'readonly' => true,
                    'name' => 'order',
                    'value' => $order->getData('increment_id'),
                ));
                $fieldset->addField('customer_name', 'text', array(
                    'label' => Mage::helper('bfr_eventparticipants')->__('Customer'),
                    'class' => 'readonly disabled',
                    'readonly' => true,
                    'name' => 'customer_name',
                    'value' => $order->getCustomerEmail(),
                ));
                $fieldset->addField('status', 'select', array(
                    'label' => Mage::helper('bfr_eventparticipants')->__('Status'),
                    'name' => 'status',
                    'value' => $agreement->getStatus(),
                    'values' => Bfr_Eventparticipants_Model_Resource_Accepted::getOptionArray(),
                ));
                $fieldset->addField('event_title', 'text', array(
                    'label' => Mage::helper('bfr_eventparticipants')->__('Event'),
                    'class' => 'readonly disabled',
                    'readonly' => true,
                    'name' => 'event_title',
                    'value' => $event->getData('title'),
                ));
                $fieldset->addField('signed_at', 'text', array(
                    'label' => Mage::helper('bfr_eventparticipants')->__('Signed At'),
                    'class' => 'readonly disabled',
                    'readonly' => true,
                    'name' => 'signed_at',
                    'value' => $agreement->getSignedAt(),
                ));
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }

        return parent::_prepareForm();
    }
}
