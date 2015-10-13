<?php

class Egovs_Import_Block_Adminhtml_Import_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'import';
        $this->_controller = 'adminhtml_import';
        
        $this->_removeButton('save');
        $this->_removeButton('delete');
        $this->_removeButton('back');
        $this->_removeButton('reset');
		
        
    }

    public function getHeaderText()
    {
            return Mage::helper('import')->__('Import Data');
    }
}