<?php
/**
 * B3it Subscription
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Block_Adminhtml_Subscription_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Block_Adminhtml_Subscription_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'b3it_subscription';
        $this->_controller = 'adminhtml_subscription';
        
        $this->_updateButton('save', 'label', Mage::helper('b3it_subscription')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('b3it_subscription')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('subscription_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'subscription_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'subscription_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
        $this->removeButton('delete');
    }

    public function getHeaderText()
    {
        if( Mage::registry('subscription_data') && Mage::registry('subscription_data')->getId() ) {
            return Mage::helper('b3it_subscription')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('subscription_data')->getSubscriptionId()));
        } else {
            return Mage::helper('b3it_subscription')->__('Add Item');
        }
    }
	
	
}