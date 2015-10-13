<?php

class Slpb_Verteiler_Block_Adminhtml_Verteiler_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('verteiler_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('verteiler')->__('Verteiler Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('verteiler')->__('Verteiler'),
          'title'     => Mage::helper('verteiler')->__('Verteiler'),
          'content'   => $this->getLayout()->createBlock('verteiler/adminhtml_verteiler_edit_tab_form')->toHtml(),
      ));
      
      $this->addTab('customer_section', array(
          'label'     => Mage::helper('verteiler')->__('Zugeordnete Kunden'),
          'title'     => Mage::helper('verteiler')->__('Zugeordnete Kunden'),
          'url'   =>  $this->getUrl('adminhtml/slpbverteiler_verteiler/customer',array('_current'=>true)),
     	  'class'  => 'ajax',
      ));
     
      return parent::_beforeToHtml();
  }
}