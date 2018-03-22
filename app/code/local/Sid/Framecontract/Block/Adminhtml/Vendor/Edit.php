<?php

class Sid_Framecontract_Block_Adminhtml_Vendor_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'framecontract';
        $this->_controller = 'adminhtml_vendor';
        
        $this->_updateButton('save', 'label', Mage::helper('framecontract')->__('Save Vendor'));
        $this->_updateButton('delete', 'label', Mage::helper('framecontract')->__('Delete Vendor'));
		
        
        $collection = Mage::getModel('framecontract/contract')->getCollection();
        $collection->getSelect()->where('framecontract_vendor_id='.intval(Mage::registry('vendor_data')->getId()));
        
        if(count($collection->getItems()) > 0)
        {
        	$this->removeButton('delete');
        }
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('vendor_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'vendor_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'vendor_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";              
        
    }

    public function getHeaderText()
    {
        if( Mage::registry('vendor_data') && Mage::registry('vendor_data')->getId() ) {
            return Mage::helper('framecontract')->__("Edit Vendor '%s'", $this->htmlEscape(Mage::registry('vendor_data')->getCompany()));
        } else {
            return Mage::helper('framecontract')->__('Add Vendor');
        }
    }
	
	
}