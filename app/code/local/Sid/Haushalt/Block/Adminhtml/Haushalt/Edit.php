<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_Block_Adminhtml_Haushalt_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'haushalt';
        $this->_controller = 'adminhtml_haushalt';
        
        $this->_updateButton('save', 'label', Mage::helper('haushalt')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('haushalt')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('haushalt_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'haushalt_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'haushalt_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('haushalt_data') && Mage::registry('haushalt_data')->getId() ) {
            return Mage::helper('haushalt')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('haushalt_data')->getTitle()));
        } else {
            return Mage::helper('haushalt')->__('Add Item');
        }
    }
}