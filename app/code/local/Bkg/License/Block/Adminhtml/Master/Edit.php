<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Master_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bkg_license';
        $this->_controller = 'adminhtml_master';

        $this->_updateButton('save', 'label', Mage::helper('bkg_license')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('bkg_license')->__('Delete Item'));


        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        		
        		
            function toggleEditor() {
                if (tinyMCE.getInstanceById('page_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'text_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'text_content');
                }
            }
		 ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('entity_data') && Mage::registry('entity_data')->getId() ) {
            return Mage::helper('bkg_license')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('entity_data')->getId()));
        } else {
            return Mage::helper('bkg_license')->__('Add Item');
        }
    }
    
    protected function _prepareLayout()
    {
    	// Load Wysiwyg on demand and Prepare layout
    	if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled() && ($block = $this->getLayout()->getBlock('head'))) {
    		$block->setCanLoadTinyMce(true);
    	}
    	return parent::_prepareLayout();
    }


}
