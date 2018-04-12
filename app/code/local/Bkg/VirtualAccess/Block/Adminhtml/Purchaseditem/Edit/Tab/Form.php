<?php

class Bkg_VirtualAccess_Block_Adminhtml_Purchaseditem_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('credential_form', array('legend'=>Mage::helper('virtualaccess')->__('Credential information')));
     

      
     $fieldset->addField('external_link_url', 'text', array(
          'label'     => Mage::helper('virtualaccess')->__('external_link_url'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'external_link_url',
      ));

 

     $data = Mage::registry('action_data');
      if ( Mage::registry('action_data') ) {
          $form->setValues(Mage::registry('action_data')->getData());
      }
      return parent::_prepareForm();
  }
}