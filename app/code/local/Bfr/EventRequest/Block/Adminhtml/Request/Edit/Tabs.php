<?php
/**
 * Bfr EventRequest
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Block_Adminhtml_Request_Edit_Tabs
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Block_Adminhtml_Request_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('request_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('eventrequest')->__('Application Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('eventrequest')->__('Application Information'),
          'title'     => Mage::helper('eventrequest')->__('Application Information'),
          'content'   => $this->getLayout()->createBlock('eventrequest/adminhtml_request_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('form_section1', array(
      		'label'     => Mage::helper('eventrequest')->__('Customer Information'),
      		'title'     => Mage::helper('eventrequest')->__('Customer Information'),
      		'content'   => $this->getLayout()->createBlock('eventrequest/adminhtml_request_edit_tab_customer')->toHtml(),
      ));
      
      $this->addTab('form_section2', array(
      		'label'     => Mage::helper('eventrequest')->__('Custom Options'),
      		'title'     => Mage::helper('eventrequest')->__('Individual Options Information'),
      		'content'   => $this->getLayout()->createBlock('eventrequest/adminhtml_request_edit_tab_individualoptions')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}