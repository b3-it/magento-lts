<?php

class Bkg_VirtualAccess_Block_Adminhtml_Purchaseditem_Edit_Tab_Credential_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $data = Mage::registry('action_data');
      $form = new Varien_Data_Form(array(
              'id' => 'edit_form',
              'action' => $this->getUrl('*/*/save', array('id' => $data->getCredentialId())),
              'method' => 'post',
              'enctype' => 'multipart/form-data'
          )
      );

      $form->setUseContainer(true);
      $this->setForm($form);
      $fieldset = $form->addFieldset('credential_form', array('legend'=>Mage::helper('virtualaccess')->__('Credential information')));

      $fieldset->addField('credential_id', 'hidden', array(
          'name'      => 'credential_id',
      ));

      $fieldset->addField('uuid', 'text', array(
          'label'     => Mage::helper('virtualaccess')->__('UUID'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'uuid',
      ));

     $fieldset->addField('ip', 'text', array(
          'label'     => Mage::helper('virtualaccess')->__('IP Address'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'ip',
      ));


 


      if ( Mage::registry('action_data') ) {
          $form->setValues(Mage::registry('action_data')->getData());
      }
      return parent::_prepareForm();
  }
}