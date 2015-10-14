<?php
/**
 * Slpb Customer
 * 
 * 
 * @category   	Slpb
 * @package    	Slpb_Customer
 * @name       	Slpb_Customer_Block_Adminhtml_Sales_Edit
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Slpb_Customer_Block_Adminhtml_Sales_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'customer';
        $this->_controller = 'adminhtml_sales';
        
        $this->_updateButton('save', 'label', Mage::helper('customer')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('customer')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('sales_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'sales_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'sales_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('sales_data') && Mage::registry('sales_data')->getId() ) {
            return Mage::helper('customer')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('sales_data')->getTitle()));
        } else {
            return Mage::helper('customer')->__('Add Item');
        }
    }
	
	
}