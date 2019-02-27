<?php

class Sid_Framecontract_Block_Adminhtml_Vendor_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('vendor_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('framecontract')->__('Vendor Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('contact', array(
          'label'     => Mage::helper('framecontract')->__('Contact'),
          'title'     => Mage::helper('framecontract')->__('Contact'),
          'content'   => $this->getLayout()->createBlock('framecontract/adminhtml_vendor_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('format', array(
      		'label'     => Mage::helper('framecontract')->__('Format'),
      		'title'     => Mage::helper('framecontract')->__('Format'),
      		'content'   => $this->getLayout()->createBlock('framecontract/adminhtml_vendor_edit_tab_format')->toHtml(),
      ));
      
      $this->addTab('transfer', array(
      		'label'     => Mage::helper('framecontract')->__('Transfer'),
      		'title'     => Mage::helper('framecontract')->__('Transfer'),
      		'content'   => $this->getLayout()->createBlock('framecontract/adminhtml_vendor_edit_tab_transfer')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}