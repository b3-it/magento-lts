<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Service_Crs_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Service_Crs_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bkgviewer';
        $this->_controller = 'adminhtml_Service_Crs';

        $this->_updateButton('save', 'label', Mage::helper('bkgviewer')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('bkgviewer')->__('Delete Item'));


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
        if( Mage::registry('servicecrs_data') && Mage::registry('servicecrs_data')->getId() ) {
            return Mage::helper('bkgviewer')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('servicecrs_data')->getTitle()));
        } else {
            return Mage::helper('bkgviewer')->__('Add Item');
        }
    }


}
