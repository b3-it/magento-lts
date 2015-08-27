<?php

class Dwd_Stationen_Block_Adminhtml_Stationen_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'stationen';
        $this->_controller = 'adminhtml_stationen';
        
        $this->_updateButton('save', 'label', Mage::helper('stationen')->__('Save Station'));
        $this->_updateButton('delete', 'label', Mage::helper('stationen')->__('Delete Station'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('stationen_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'stationen_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'stationen_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
        
        if( Mage::registry('stationen_data') && Mage::registry('stationen_data')->getId() )
        {
        	if(Mage::registry('stationen_data')->getStatus() == Dwd_Stationen_Model_Stationen_Status::STATUS_DELETED)
        	{
        		$this->_removeButton('save');
        		$this->_removeButton('saveandcontinue');
        	}
        }
    }

    public function getHeaderText()
    {
        if( Mage::registry('stationen_data') && Mage::registry('stationen_data')->getId() ) {
            return Mage::helper('stationen')->__("Edit Station '%s'", $this->htmlEscape(Mage::registry('stationen_data')->getName()));
        } else {
            return Mage::helper('stationen')->__('Add Station');
        }
    }
	
	
}