<?php

class Dwd_Stationen_Block_Adminhtml_Set_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('set_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('stationen')->__('Set Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('stationen')->__('Set Information'),
          'title'     => Mage::helper('stationen')->__('Set Information'),
          'content'   => $this->getLayout()->createBlock('stationen/adminhtml_set_edit_tab_form')->toHtml(),
      ));
      
     //wir brauchen die id
     $model = Mage::registry('set_data'); 
      
     if($model->getId())
     {
	     $this->addTab('station_section', array(
	          'label'     => Mage::helper('stationen')->__('Assigned Stations'),
	          'title'     => Mage::helper('stationen')->__('Stations'),
	          'url'   =>  $this->getUrl('*/stationen_set/stationen',array('_current'=>true)),
	     	'class'  => 'ajax',
	      ));
	      
	     $this->addTab('products_section', array(
	          'label'     => Mage::helper('stationen')->__('Assigned Products'),
	          'title'     => Mage::helper('stationen')->__('Products'),
	     	  'url'   =>  $this->getUrl('*/stationen_set/products',array('_current'=>true)),
	     	  'class'  => 'ajax',
	          
	      ));
     }
      return parent::_beforeToHtml();
  }
}