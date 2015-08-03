<?php

class Egovs_Extnewsletter_Block_Adminhtml_Issue_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'extnewsletter';
        $this->_controller = 'adminhtml_issue';
        
        $this->_updateButton('save', 'label', Mage::helper('extnewsletter')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('extnewsletter')->__('Delete'));

        
        /*
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('issue_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'issue_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'issue_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
        */
    }

    public function getHeaderText()
    {
        if( Mage::registry('issue_data') && Mage::registry('issue_data')->getId() ) {
            return Mage::helper('extnewsletter')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('issue_data')->getTitle()));
        } else {
            return Mage::helper('extnewsletter')->__('Add Item');
        }
    }
    
  
}