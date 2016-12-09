<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category B3it
 *  @package  B3it_Pendelliste
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_Pendelliste_Block_Adminhtml_Pendelliste_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'pendelliste';
        $this->_controller = 'adminhtml_pendelliste';
        
        $this->_updateButton('save', 'label', Mage::helper('pendelliste')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('pendelliste')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('pendelliste_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'pendelliste_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'pendelliste_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('pendelliste_data') && Mage::registry('pendelliste_data')->getId() ) {
            return Mage::helper('pendelliste')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('pendelliste_data')->getTitle()));
        } else {
            return Mage::helper('pendelliste')->__('Add Item');
        }
    }
}