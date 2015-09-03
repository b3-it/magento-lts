<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Dwd
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Dwd_Abomigration_Block_Adminhtml_Abomigration_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'abomigration';
        $this->_controller = 'adminhtml_abomigration';
        
        $this->_updateButton('save', 'label', Mage::helper('abomigration')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('abomigration')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('abomigration_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'abomigration_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'abomigration_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('abomigration_data') && Mage::registry('abomigration_data')->getId() ) {
            return Mage::helper('abomigration')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('abomigration_data')->getLastname()));
        } else {
            return Mage::helper('abomigration')->__('Add Item');
        }
    }
}