<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name       	Bkg_Regionallocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_RegionAllocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'regionallocation';
        $this->_controller = 'adminhtml_koenigsteinerschluessel_kst';

        $this->_updateButton('save', 'label', Mage::helper('regionallocation')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('regionallocation')->__('Delete Item'));


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
        if( Mage::registry('koenigsteinerschluesselkst_data') && Mage::registry('koenigsteinerschluesselkst_data')->getId() ) {
            return Mage::helper('regionallocation')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('koenigsteinerschluesselkst_data')->getId()));
        } else {
            return Mage::helper('regionallocation')->__('Add Item');
        }
    }


}
