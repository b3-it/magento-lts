<?php

class Dwd_ConfigurableVirtual_Block_Adminhtml_Credential_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'configvirtual';
        $this->_controller = 'adminhtml_credential';
        
        $this->_updateButton('save', 'label', Mage::helper('configvirtual')->__('Save Credential'));
        //$this->_updateButton('delete', 'label', Mage::helper('configvirtual')->__('Delete Item'));
		$this->_removeButton('delete');
			
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
    	return Mage::helper('configvirtual')->__("Edit Credential");
    	
        if( Mage::registry('credential_data') && Mage::registry('credential_data')->getId() ) {
            return Mage::helper('configvirtual')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('credential_data')->getTitle()));
        } else {
            return Mage::helper('configvirtual')->__('Add Item');
        }
    }
	
	
}