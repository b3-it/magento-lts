<?php
/**
 * Egovs Infoletter
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter_Block_Adminhtml_Queue_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Infoletter_Block_Adminhtml_Queue_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'infoletter';
        $this->_controller = 'adminhtml_queue';
        
        $this->_updateButton('save', 'label', Mage::helper('infoletter')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('infoletter')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('queue_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'queue_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'queue_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('queue_data') && Mage::registry('queue_data')->getId() ) {
            return Mage::helper('infoletter')->__("Edit Queue '%s'", $this->htmlEscape(Mage::registry('queue_data')->getName()));
        } else {
            return Mage::helper('infoletter')->__('Add Queue');
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