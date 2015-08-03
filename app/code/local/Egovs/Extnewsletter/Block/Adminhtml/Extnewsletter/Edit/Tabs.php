<?php

class Egovs_Extnewsletter_Block_Adminhtml_Extnewsletter_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('extnewsletter_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('extnewsletter')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('extnewsletter')->__('Item Information'),
          'title'     => Mage::helper('extnewsletter')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('extnewsletter/adminhtml_extnewsletter_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}