<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Participant_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Participant_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('participant_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('eventmanager')->__('Participant Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('eventmanager')->__('Personal'),
          'title'     => Mage::helper('eventmanager')->__('Personal'),
          'content'   => $this->getLayout()->createBlock('eventmanager/adminhtml_participant_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('form_section2', array(
      		'label'     => Mage::helper('eventmanager')->__('Attribute'),
      		'title'     => Mage::helper('eventmanager')->__('Attribute'),
      		'content'   => $this->getLayout()->createBlock('eventmanager/adminhtml_participant_edit_tab_attribute')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}