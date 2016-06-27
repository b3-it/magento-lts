<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Participant_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Participant_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'eventmanager';
        $this->_controller = 'adminhtml_participant';
        
        $this->_updateButton('save', 'label', Mage::helper('eventmanager')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('eventmanager')->__('Delete Item'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('participant_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'participant_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'participant_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
        
       
        
    }

    public function getBackUrl()
    {
    	$eventId = intval($this->getRequest()->getParam('event'));
    	if($eventId > 0){
    		return $this->getBack2EventUrl($eventId);
    	}
    	
    	return parent::getBackUrl();
    }
    
    
    public function getBack2EventUrl($eventId)
    {
    	return $this->getUrl(
    			'*/eventmanager_event/edit',
    			array(
    					'id'  => $eventId,
    					'active_tab'=> 'participants_section'
    			));
    }
    
    
    public function getHeaderText()
    {
        if( Mage::registry('participant_data') && Mage::registry('participant_data')->getId() ) {
            return Mage::helper('eventmanager')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('participant_data')->getId()));
        } else {
            return Mage::helper('eventmanager')->__('Add Item');
        }
    }
	
	
}