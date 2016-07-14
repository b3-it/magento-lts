<?php

class Sid_Framecontract_Block_Adminhtml_Contract_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('contract_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('framecontract')->__('Contract Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('framecontract')->__('General Contract Information'),
          'title'     => Mage::helper('framecontract')->__('General Contract Information'),
          'content'   => $this->getLayout()->createBlock('framecontract/adminhtml_contract_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('form_section0', array(
      		'label'     => Mage::helper('framecontract')->__('Lose'),
      		'title'     => Mage::helper('framecontract')->__('Lose'),
      		'content'   => $this->getLayout()->createBlock('framecontract/adminhtml_contract_edit_tab_los')->toHtml(),
      ));
      
      
     $this->addTab('form_section1', array(
          'label'     => Mage::helper('framecontract')->__('Configuration Files'),
          'title'     => Mage::helper('framecontract')->__('Configuration Files'),
          'content'   => $this->getLayout()->createBlock('framecontract/adminhtml_contract_edit_tab_files')->toHtml(),
      ));
      
    $this->addTab('form_section2', array(
          'label'     => Mage::helper('framecontract')->__('Message History'),
          'title'     => Mage::helper('framecontract')->__('Message History'),
          'content'   => $this->getLayout()->createBlock('framecontract/adminhtml_contract_edit_tab_transmit')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}