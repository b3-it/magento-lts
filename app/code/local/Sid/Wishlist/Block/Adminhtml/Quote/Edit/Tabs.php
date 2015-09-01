<?php

class Sid_Wishlist_Block_Adminhtml_Quote_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('quote_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('sidwishlist')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('sidwishlist')->__('Item Information'),
          'title'     => Mage::helper('sidwishlist')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('sidwishlist/adminhtml_quote_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}