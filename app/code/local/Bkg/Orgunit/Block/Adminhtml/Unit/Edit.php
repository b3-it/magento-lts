<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Block_Adminhtml_Unit_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Block_Adminhtml_Unit_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bkg_orgunit';
        $this->_controller = 'adminhtml_unit';

        $this->_updateButton('save', 'label', Mage::helper('bkg_orgunit')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('bkg_orgunit')->__('Delete Item'));


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
        
         if( Mage::registry('unit_data') && Mage::registry('unit_data')->getId())
         {
         	$orgunit = Mage::registry('unit_data');
         	$is_used=$orgunit->isOrganisationUsed();
         	if($is_used !== false){
         		$this->removeButton('delete');
         		
         	}
         }
        
    }

    public function getHeaderText()
    {
        if( Mage::registry('unit_data') && Mage::registry('unit_data')->getId() ) {
            return Mage::helper('bkg_orgunit')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('unit_data')->getName()));
        } else {
            return Mage::helper('bkg_orgunit')->__('Add Item');
        }
    }


}
