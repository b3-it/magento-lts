<?php

class Slpb_Verteiler_Block_Adminhtml_Verteiler_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('verteiler_form', array('legend'=>Mage::helper('verteiler')->__('Verteiler Details')));
     
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('verteiler')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
      $fieldset->addField('description', 'textarea', array(
          'label'     => Mage::helper('verteiler')->__('Description'),

          'name'      => 'description',
      ));
      

 	
     
      if ( Mage::getSingleton('adminhtml/session')->getVerteilerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getVerteilerData());
          Mage::getSingleton('adminhtml/session')->setVerteilerData(null);
      } elseif ( Mage::registry('verteiler_data') ) {
          $form->setValues(Mage::registry('verteiler_data')->getData());
      }
      return parent::_prepareForm();
  }
}