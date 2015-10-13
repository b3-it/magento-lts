<?php

/**
 * 
 *  Edit Block für pdf Template-Blöcke
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Block_Adminhtml_Blocks_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'pdftemplate';
        $this->_controller = 'adminhtml_blocks';
        
        $this->_updateButton('save', 'label', Mage::helper('pdftemplate')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('pdftemplate')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('blocks_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'blocks_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'blocks_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('blocks_data') && Mage::registry('blocks_data')->getId() ) {
            return Mage::helper('pdftemplate')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('blocks_data')->getTitle()));
        } else {
            return Mage::helper('pdftemplate')->__('Add Item');
        }
    }
	
	
}