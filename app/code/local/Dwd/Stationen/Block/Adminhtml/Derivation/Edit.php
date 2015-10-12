<?php

class Dwd_Stationen_Block_Adminhtml_Derivation_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'stationen';
        $this->_controller = 'adminhtml_derivation';
        
        $this->_updateButton('save', 'label', Mage::helper('stationen')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('stationen')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('derivation_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'derivation_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'derivation_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('derivation_data') && Mage::registry('derivation_data')->getId() ) {
            return Mage::helper('stationen')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('derivation_data')->getName()));
        } else {
            return Mage::helper('stationen')->__('Add Item');
        }
    }
	
	public function getBackUrl()
    {
    	$model = Mage::registry('derivation_data');
        return $this->getUrl('*/stationen_stationen/edit',array('id'=> $model->getParentId(),'tab'=>'derivation_section'));
    }
	
}