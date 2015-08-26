<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Account_Edit
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Account_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'dwd_icd';
        $this->_controller = 'adminhtml_account';
        
        $this->_updateButton('save', 'label', Mage::helper('dwd_icd')->__('Save Item'));
        //$this->_updateButton('delete', 'label', Mage::helper('dwd_icd')->__('Delete Item'));
        $this->_removeButton('delete');
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('account_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'account_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'account_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('account_data') && Mage::registry('account_data')->getId() ) {
            return Mage::helper('dwd_icd')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('account_data')->getLogin()));
        } else {
            return Mage::helper('dwd_icd')->__('Add Item');
        }
    }
	
	
}