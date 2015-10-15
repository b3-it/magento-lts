<?php

class Dimdi_Import_Block_Adminhtml_Import_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
		
        $this->_addButton('customer', array(
            'label'     => Mage::helper('adminhtml')->__('Import Customer'),
            'onclick'   => 'importCustomer()',
            'class'     => 'save',
        ), -100);

        $this->_addButton('hparameter', array(
        		'label'     => Mage::helper('adminhtml')->__('Import Haushaltparameter'),
        		'onclick'   => 'importHparameter()',
        		'class'     => 'save',
        ), -100);
        
        
       $this->_addButton('category', array(
            'label'     => Mage::helper('adminhtml')->__('Import Categories'),
            'onclick'   => 'importCategory()',
            'class'     => 'save',
        ), -100);
        
       $this->_addButton('products', array(
            'label'     => Mage::helper('adminhtml')->__('Import Products'),
            'onclick'   => 'importProducts()',
            'class'     => 'save',
        ), -100);
        
       $this->_addButton('orders', array(
            'label'     => Mage::helper('adminhtml')->__('Import Orders'),
            'onclick'   => 'importOrders()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
        	function importCustomer(){
                new Ajax.Updater('message',$('edit_form').action+'import/customer/',{method:'get',
                parameters: $('edit_form').serialize(true)});
            }
            
            function importCategory(){
                new Ajax.Updater('message',$('edit_form').action+'import/category/',{method:'get',
                parameters: $('edit_form').serialize(true)});
            }
            
            function importHparameter(){
                new Ajax.Updater('message',$('edit_form').action+'import/hparameter/',{method:'get',
                parameters: $('edit_form').serialize(true)});
            }
        		
       		function importProducts(){
                new Ajax.Updater('message',$('edit_form').action+'import/products/',{method:'get',
                parameters: $('edit_form').serialize(true)});
            }
            
            function importOrders(){
                new Ajax.Updater('message',$('edit_form').action+'import/orders/',{method:'get',
                parameters: $('edit_form').serialize(true)});
            }
        ";
    }

    public function getHeaderText()
    {
            return Mage::helper('import')->__('Import OsCommerce Data');
    }
}