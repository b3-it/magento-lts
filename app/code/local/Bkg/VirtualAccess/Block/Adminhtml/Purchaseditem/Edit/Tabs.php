<?php

class Bkg_VirtualAccess_Block_Adminhtml_Purchaseditem_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('credential_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('virtualaccess')->__('Credentials'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('virtualaccess')->__('Purchased Items'),
          'title'     => Mage::helper('virtualaccess')->__('Purchased Items'),
          'content'   => $this->getLayout()->createBlock('virtualaccess/adminhtml_purchaseditem_edit_tab_form')->toHtml(),
      ));
      
     $this->addTab('purchased_section', array(
          'label'     => Mage::helper('virtualaccess')->__('Credentials'),
          'title'     => Mage::helper('virtualaccess')->__('Credentials'),
          'content'   => $this->getLayout()->createBlock('virtualaccess/adminhtml_purchaseditem_edit_tab_credential')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}