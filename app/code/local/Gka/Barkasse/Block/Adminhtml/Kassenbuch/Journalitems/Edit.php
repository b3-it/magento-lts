<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journalitems_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journalitems_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'gka_barkasse';
        $this->_controller = 'adminhtml_kassenbuch_journalitems';

        $this->_updateButton('save', 'label', Mage::helper('gka_barkasse')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('gka_barkasse')->__('Delete Item'));


        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('kassenbuchjournal_items_data') && Mage::registry('kassenbuchjournal_items_data')->getId() ) {
            return Mage::helper('gka_barkasse')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('kassenbuchjournal_items_data')->getId()));
        } else {
            return Mage::helper('gka_barkasse')->__('Add Item');
        }
    }


}