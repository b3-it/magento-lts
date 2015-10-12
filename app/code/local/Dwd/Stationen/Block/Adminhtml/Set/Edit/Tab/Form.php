<?php

class Dwd_Stationen_Block_Adminhtml_Set_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('set_form', array('legend'=>Mage::helper('stationen')->__('Item information')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('stationen')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
     $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('stationen')->__('Status'),
          'name'      => 'status',
          'values'    => Dwd_Stationen_Model_Set_Status::getOptionHashArray(),
      ));
     
      
      $fieldset->addField('show_active_only', 'select', array(
          'label'     => Mage::helper('stationen')->__('show active stations only'),
          //'class'     => 'required-entry',
          //'required'  => false,
          'name'      => 'show_active_only',
          'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
  		));
  
      $fieldset->addField('short_description', 'editor', array(
          'name'      => 'short_description',
          'label'     => Mage::helper('stationen')->__('Short Description'),
          'title'     => Mage::helper('stationen')->__('Short Description'),
          'style'     => 'width:700px; height:200px;',
          'wysiwyg'   => false,
          //'required'  => true,
      ));
      
      $fieldset->addField('description', 'editor', array(
          'name'      => 'description',
          'label'     => Mage::helper('stationen')->__('Description'),
          'title'     => Mage::helper('stationen')->__('Description'),
          'style'     => 'width:700px; height:200px;',
          'wysiwyg'   => false,
          //'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getStationenData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getStationenData());
          Mage::getSingleton('adminhtml/session')->setStationenData(null);
      } elseif ( Mage::registry('set_data') ) {
          $form->setValues(Mage::registry('set_data')->getData());
      }
      return parent::_prepareForm();
  }
}