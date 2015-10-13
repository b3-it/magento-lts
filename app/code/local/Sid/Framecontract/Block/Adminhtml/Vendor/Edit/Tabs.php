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
      $this->addTab('form_section', array(
          'label'     => Mage::helper('framecontract')->__('Vendor Information'),
          'title'     => Mage::helper('framecontract')->__('Vendor Information'),
          'content'   => $this->getLayout()->createBlock('framecontract/adminhtml_vendor_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}