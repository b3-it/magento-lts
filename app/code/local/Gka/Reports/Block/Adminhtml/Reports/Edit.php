<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Gka
 *  @package  Gka_Reports
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_Reports_Block_Adminhtml_Reports_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'reports';
        $this->_controller = 'adminhtml_reports';
        
        $this->_updateButton('save', 'label', Mage::helper('reports')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('reports')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('reports_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'reports_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'reports_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('reports_data') && Mage::registry('reports_data')->getId() ) {
            return Mage::helper('reports')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('reports_data')->getTitle()));
        } else {
            return Mage::helper('reports')->__('Add Item');
        }
    }
}