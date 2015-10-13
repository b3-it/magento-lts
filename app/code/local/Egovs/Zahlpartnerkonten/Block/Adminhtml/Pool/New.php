<?php

class Egovs_Zahlpartnerkonten_Block_Adminhtml_Pool_New extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'zpkonten';
        $this->_controller = 'adminhtml_pool';
        $this->_mode 	= 'new';
        
        $this->_updateButton('save', 'label', Mage::helper('zpkonten')->__('Create'));
        //$this->_updateButton('delete', 'label', Mage::helper('zahlpartnerkonten')->__('Delete Item'));
		
		
    }

    public function getHeaderText()
    {
        return Mage::helper('zpkonten')->__('Create Kassenzeichen');
    }
	
	
}