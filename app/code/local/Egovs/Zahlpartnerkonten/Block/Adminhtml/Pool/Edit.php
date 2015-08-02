<?php

class Egovs_Zahlpartnerkonten_Block_Adminhtml_Pool_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'zpkonten';
        $this->_controller = 'adminhtml_pool';
        
        $this->_updateButton('save', 'label', Mage::helper('zpkonten')->__('Save'));
        $this->_removeButton('delete');
     }

    public function getHeaderText()
    {
        if( Mage::registry('pool_data') && Mage::registry('pool_data')->getId() ) {
            return Mage::helper('zpkonten')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('pool_data')->getKassenzeichen()));
        } else {
            return Mage::helper('zpkonten')->__('Add Item');
        }
    }
	
	
}