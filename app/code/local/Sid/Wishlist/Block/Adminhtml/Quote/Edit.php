<?php

class Sid_Wishlist_Block_Adminhtml_Quote_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sidwishlist';
        $this->_controller = 'adminhtml_quote';
        
        $this->_updateButton('save', 'label', Mage::helper('sidwishlist')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('sidwishlist')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('quote_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'quote_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'quote_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('quote_data') && Mage::registry('quote_data')->getId() ) {
            return Mage::helper('sidwishlist')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('quote_data')->getTitle()));
        } else {
            return Mage::helper('sidwishlist')->__('Add Item');
        }
    }
	
	
}