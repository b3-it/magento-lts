<?php

class Egovs_Informationservice_Block_Adminhtml_Request_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'informationservice';
        $this->_controller = 'adminhtml_request';
        
        $this->_updateButton('save', 'label', Mage::helper('informationservice')->__('Save Request'));
        $this->_updateButton('delete', 'label', Mage::helper('informationservice')->__('Delete Request'));
		
			
 
        
        
        $data = Mage::registry('request_data');
	
		if(isset($data['request']['status']))
		{
			$data = $data['request']['status'];
		}
		else $data = 0;
		
		if(($data == Egovs_Informationservice_Model_Status::STATUS_CLOSED) || ($data == Egovs_Informationservice_Model_Status::STATUS_CANCELED) )
		{
	        $this->_removeButton('save');
	        $this->_removeButton('reset');
	    }else 
	    {
	    	$this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        	), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('request_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'request_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'request_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
	    }
    }

    public function getHeaderText()
    {
    	return;
        if( Mage::registry('request_data') && Mage::registry('request_data')) {
            return Mage::helper('informationservice')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('request_data')->getTitle()));
        } else {
            return Mage::helper('informationservice')->__('Add Item');
        }
    }
	
	
}