<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Connection_Edit
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Connection_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'dwd_icd';
        $this->_controller = 'adminhtml_connection';
        
        $this->_updateButton('save', 'label', Mage::helper('dwd_icd')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('dwd_icd')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('connection_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'connection_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'connection_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('connection_data') && Mage::registry('connection_data')->getId() ) {
            return Mage::helper('dwd_icd')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('connection_data')->getTitle()));
        } else {
            return Mage::helper('dwd_icd')->__('Add Item');
        }
    }
	
	
}