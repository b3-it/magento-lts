<?php
/**
 * Sid Cms
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms_Block_Adminhtml_Navi_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Block_Adminhtml_Navi_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'sidcms';
        $this->_controller = 'adminhtml_navi';
        
        $this->_updateButton('save', 'label', Mage::helper('sidcms')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('sidcms')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('navi_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'navi_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'navi_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
    	$navi = Mage::registry('navi_data');
    	$store = Mage::getModel('core/store')->load($navi->getStoreId());
        return Mage::helper('sidcms')->__("Edit '%s' (%s)", $this->htmlEscape(Mage::registry('navi_data')->getTitle()),$store->getName());
        
    }
	
	
}