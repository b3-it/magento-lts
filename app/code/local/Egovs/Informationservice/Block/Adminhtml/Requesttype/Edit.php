<?php

class Egovs_Informationservice_Block_Adminhtml_Requesttype_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'informationservice';
        $this->_controller = 'adminhtml_requesttype';
        
        $this->_updateButton('save', 'label', Mage::helper('informationservice')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('informationservice')->__('Delete'));
		
    }

    public function getHeaderText()
    {
        if( Mage::registry('requesttype_data') && Mage::registry('requesttype_data')->getId() ) {
            return Mage::helper('informationservice')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('requesttype_data')->getTitle()));
        } else {
            return Mage::helper('informationservice')->__('Add Item');
        }
    }
	
	
}