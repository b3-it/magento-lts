<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Lookup_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Lookup_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'eventmanager';
        $this->_controller = 'adminhtml_lookup';
        
        $this->_updateButton('save', 'label', Mage::helper('eventmanager')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('eventmanager')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('lookup_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'lookup_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'lookup_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('lookup_data') && Mage::registry('lookup_data')->getId() ) {
            return Mage::helper('eventmanager')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('lookup_data')->getValue()));
        } else {
            return Mage::helper('eventmanager')->__('Add Item');
        }
    }
	
	
}