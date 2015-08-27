<?php

class Dwd_ConfigurableVirtual_Block_Adminhtml_Credential_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('credential_form', array('legend'=>Mage::helper('configvirtual')->__('Credential information')));
     
      $fieldset->addField('username', 'text', array(
          'label'     => Mage::helper('configvirtual')->__('Username'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'username',
      ));
      
     $fieldset->addField('password', 'text', array(
          'label'     => Mage::helper('configvirtual')->__('Password'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'password',
      ));

 
     
      if ( Mage::getSingleton('adminhtml/session')->getConfigurableVirtualData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getConfigurableVirtualData());
          Mage::getSingleton('adminhtml/session')->setConfigurableVirtualData(null);
      } elseif ( Mage::registry('credential_data') ) {
          $form->setValues(Mage::registry('credential_data')->getData());
      }
      return parent::_prepareForm();
  }
}