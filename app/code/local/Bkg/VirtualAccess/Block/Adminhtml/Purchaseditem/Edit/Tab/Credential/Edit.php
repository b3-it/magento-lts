<?php

class Bkg_VirtualAccess_Block_Adminhtml_Purchaseditem_Edit_Tab_Credential_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'virtualaccess';
        $this->_controller = 'adminhtml_purchaseditem';
        $this->_mode = 'edit_tab_credential';
        
        $this->_updateButton('save', 'label', Mage::helper('virtualaccess')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('virtualaccess')->__('Delete Item'));

        $this->_removeButton('reset');
    }

    public function getHeaderText()
    {
    	return Mage::helper('virtualaccess')->__("Edit Credential");

    }
	
	
}