<?php

class Egovs_Import_Block_Adminhtml_Export_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'import';
        $this->_controller = 'adminhtml_export';
        
        $this->_removeButton('save');
        $this->_removeButton('delete');
        $this->_removeButton('back');
        $this->_removeButton('reset');
		
        $this->_addButton('customer', array(
            'label'     => Mage::helper('adminhtml')->__('Export Customer'),
            'onclick'   => 'exportCustomer()',
            'class'     => 'save',
        ), -100);

        
        $this->_formScripts[] = "
        	function exportCustomer(){
                new Ajax.Updater('message',$('edit_form').action+'export/customer/',{method:'get',
                parameters: $('edit_form').serialize(true)});
            }
            
           
        ";
    }

    public function getHeaderText()
    {
            return Mage::helper('import')->__('Export Data');
    }
}