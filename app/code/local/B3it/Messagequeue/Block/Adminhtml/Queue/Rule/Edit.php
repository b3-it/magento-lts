<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Block_Adminhtml_Queue_Rule_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Block_Adminhtml_Queue_Rule_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'b3it_mq';
        $this->_controller = 'adminhtml_queue_rule';

        $this->_updateButton('save', 'label', Mage::helper('b3it_mq')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('b3it_mq')->__('Delete Item'));


        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('queuerule_data') && Mage::registry('queuerule_data')->getId() ) {
            return Mage::helper('b3it_mq')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('queuerule_data')->getId()));
        } else {
            return Mage::helper('b3it_mq')->__('Add Item');
        }
    }


}
