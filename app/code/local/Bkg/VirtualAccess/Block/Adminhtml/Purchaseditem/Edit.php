<?php

class Bkg_VirtualAccess_Block_Adminhtml_Purchaseditem_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'virtualaccess';
        $this->_controller = 'adminhtml_purchaseditem';
        
        $this->_updateButton('save', 'label', Mage::helper('virtualaccess')->__('Save Credential'));
        //$this->_updateButton('delete', 'label', Mage::helper('virtualaccess')->__('Delete Item'));
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
    	return Mage::helper('virtualaccess')->__("Edit Credential");
    	
        if( Mage::registry('credential_data') && Mage::registry('credential_data')->getId() ) {
            return Mage::helper('virtualaccess')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('credential_data')->getTitle()));
        } else {
            return Mage::helper('virtualaccess')->__('Add Item');
        }
    }
	
	
}