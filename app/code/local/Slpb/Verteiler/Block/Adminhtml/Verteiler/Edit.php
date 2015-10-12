<?php

class Slpb_Verteiler_Block_Adminhtml_Verteiler_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'verteiler';
        $this->_controller = 'adminhtml_verteiler';
        
        $this->_updateButton('save', 'label', Mage::helper('verteiler')->__('Speichern'));
        $this->_updateButton('delete', 'label', Mage::helper('verteiler')->__('L&ouml;schen'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('verteiler_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'verteiler_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'verteiler_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('verteiler_data') && Mage::registry('verteiler_data')->getId() ) {
            return Mage::helper('verteiler')->__("Verteiler '%s' bearbeiten", $this->htmlEscape(Mage::registry('verteiler_data')->getName()));
        } else {
            return Mage::helper('verteiler')->__('Neuer Verteiler');
        }
    }
	
	
}