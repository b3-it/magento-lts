<?php

class Dwd_ConfigurableVirtual_Block_Adminhtml_Credential_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('credential_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('configvirtual')->__('Credentials'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('configvirtual')->__('Credential'),
          'title'     => Mage::helper('configvirtual')->__('Credential'),
          'content'   => $this->getLayout()->createBlock('configvirtual/adminhtml_credential_edit_tab_form')->toHtml(),
      ));
      
     $this->addTab('purchased_section', array(
          'label'     => Mage::helper('configvirtual')->__('Purchased Items'),
          'title'     => Mage::helper('configvirtual')->__('Purchased Items'),
          'content'   => $this->getLayout()->createBlock('configvirtual/adminhtml_credential_edit_tab_purchased')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}