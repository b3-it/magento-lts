<?php
/**
 *
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Block_Adminhtml_Periodntity_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Block_Adminhtml_Period_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'b3it_subscription';
        $this->_controller = 'adminhtml_period';

        $this->_updateButton('save', 'label', Mage::helper('b3it_subscription')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('b3it_subscription')->__('Delete Item'));


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
        if( Mage::registry('entity_data') && Mage::registry('entity_data')->getId() ) {
            return Mage::helper('b3it_subscription')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('entity_data')->getId()));
        } else {
            return Mage::helper('b3it_subscription')->__('Add Item');
        }
    }


}
