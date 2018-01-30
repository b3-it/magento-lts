<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Block_Adminhtml__Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Block_Adminhtml__Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bkg_orgUnit';
        $this->_controller = 'adminhtml_';

        $this->_updateButton('save', 'label', Mage::helper('bkg_orgUnit')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('bkg_orgUnit')->__('Delete Item'));


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
        if( Mage::registry('_data') && Mage::registry('_data')->getId() ) {
            return Mage::helper('bkg_orgUnit')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('_data')->getId()));
        } else {
            return Mage::helper('bkg_orgUnit')->__('Add Item');
        }
    }


}
