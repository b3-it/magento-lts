<?php

class Dwd_Stationen_Block_Adminhtml_Set_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'stationen';
        $this->_controller = 'adminhtml_set';
        
        $this->_updateButton('save', 'label', Mage::helper('stationen')->__('Save Set'));
        $this->_updateButton('delete', 'label', Mage::helper('stationen')->__('Delete Set'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        if($this->getSetId())
        {
	       $this->_addButton('dublicate', array(
	                'label' => Mage::helper('customer')->__('Duplicate'),
	                'onclick' => 'setLocation(\'' . $this->getDublicateUrl() . '\')',
	                'class' => 'add',
	            ), 0);
    
        }
        
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('set_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'set_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'set_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('set_data') && Mage::registry('set_data')->getId() ) {
            return Mage::helper('stationen')->__("Edit Set '%s'", $this->htmlEscape(Mage::registry('set_data')->getName()));
        } else {
            return Mage::helper('stationen')->__('Add Set');
        }
    }
	
	public function getDublicateUrl()
    {
        return $this->getUrl('*/*/duplicate', array('setid' => $this->getSetId()));
    }
    
    public function getSetId()
    {
        return Mage::registry('set_data')->getId();
    }
	
}