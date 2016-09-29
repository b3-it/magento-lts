<?php
/**
 * Sid ExportOrder
 * 
 * 
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Block_Adminhtml_Export_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Block_Adminhtml_Export_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'exportorder';
        $this->_controller = 'adminhtml_export';
        
        $this->_updateButton('save', 'label', Mage::helper('exportorder')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('exportorder')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('export_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'export_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'export_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('export_data') && Mage::registry('export_data')->getId() ) {
            return Mage::helper('exportorder')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('export_data')->getTitle()));
        } else {
            return Mage::helper('exportorder')->__('Add Item');
        }
    }
	
	
}