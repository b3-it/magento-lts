<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Block_Adminhtml_Abo_Edit
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Block_Adminhtml_Abo_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'dwd_abo';
        $this->_controller = 'adminhtml_abo';
        
        $this->_updateButton('save', 'label', Mage::helper('dwd_abo')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('dwd_abo')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('abo_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'abo_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'abo_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
        $this->removeButton('delete');
    }

    public function getHeaderText()
    {
        if( Mage::registry('abo_data') && Mage::registry('abo_data')->getId() ) {
            return Mage::helper('dwd_abo')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('abo_data')->getAboId()));
        } else {
            return Mage::helper('dwd_abo')->__('Add Item');
        }
    }
	
	
}