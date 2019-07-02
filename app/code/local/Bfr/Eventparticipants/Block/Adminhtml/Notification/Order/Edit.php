<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package     Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Block_Adminhtml_Notification_Order_Edit
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Block_Adminhtml_Notification_Order_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bfr_eventparticipants';
        $this->_controller = 'adminhtml_notification_order';

        $this->_updateButton('save', 'label', Mage::helper('bfr_eventparticipants')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('bfr_eventparticipants')->__('Delete Item'));


        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if (Mage::registry('notificationorder_data') && Mage::registry('notificationorder_data')->getId()) {
            return Mage::helper('bfr_eventparticipants')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('notificationorder_data')->getId()));
        } else {
            return Mage::helper('bfr_eventparticipants')->__('Add Item');
        }
    }


}
