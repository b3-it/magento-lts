<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Storageentity_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Storage_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'virtualgeo';
        $this->_controller = 'adminhtml_components_storage';

        $this->_updateButton('save', 'label', Mage::helper('virtualgeo')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('virtualgeo')->__('Delete Item'));


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
        if( Mage::registry('componentsstorage_entity_data') && Mage::registry('componentsstorage_entity_data')->getId() ) {
            return Mage::helper('virtualgeo')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('componentsstorage_entity_data')->getId()));
        } else {
            return Mage::helper('virtualgeo')->__('Add Item');
        }
    }


}
