<?php
/**
 * Bfr EventRequest
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Block_Adminhtml_Request_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Block_Adminhtml_Request_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'eventrequest';
        $this->_controller = 'adminhtml_request';
        
        $this->_updateButton('save', 'label', Mage::helper('eventrequest')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('eventrequest')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('eventrequest')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('request_data') && Mage::registry('request_data')->getId() ) {
            return Mage::helper('eventrequest')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('request_data')->getCustomerName()));
        } else {
            return Mage::helper('eventrequest')->__('Add Item');
        }
    }
	
	
}