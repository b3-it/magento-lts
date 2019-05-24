<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Event_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Event_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'eventmanager';
        $this->_controller = 'adminhtml_event';
        
        $this->_updateButton('save', 'label', Mage::helper('eventmanager')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('eventmanager')->__('Delete Event'));
        $this->_updateButton('delete', 'onclick',
            'deleteConfirm(\''
                . Mage::helper('core')->jsQuoteEscape(
                    Mage::helper('eventmanager')->__('Are you sure you want to delete the whole event?')
                )
                .'\', \''
                . $this->getDeleteUrl()
                . '\')'
        );
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
        
        $this->_addButton('copytocms', array(
        		'label'     => Mage::helper('adminhtml')->__('Create CMS'),
        		'onclick'   => 'setLocation(\''
				. $this->getUrl('*/eventmanager_toCms/index', array('id'=>$this->getRequest()->getParam('id', 0))).'\')',
        		'class'     => 'save',
        ), -100);

        if( Mage::getSingleton('admin/session')->isAllowed('admin/bfr_eventmanager/eventmanager_event_remove_individual_options')) {
            $this->_addButton('delete_options', array(
                'label' => Mage::helper('adminhtml')->__('Delete Individual Options'),
                'onclick' => 'deleteConfirm(\''
                    . Mage::helper('core')->jsQuoteEscape(
                        Mage::helper('eventmanager')->__('Are you sure you want to delete individual Options')
                    )
                    . '\', \''
                    . $this->getUrl('*/*/removeIndividualoptions', array('id' => $this->getRequest()->getParam('id', 0))) . '\')'
            ,
                'class' => 'delete',
            ), -100);
        }

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('event_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'event_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'event_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('event_data') && Mage::registry('event_data')->getId() ) {
            return Mage::helper('eventmanager')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('event_data')->getTitle()));
        } else {
            return Mage::helper('eventmanager')->__('Add Item');
        }
    }
	
	
}