<?php

class Sid_Framecontract_Block_Adminhtml_Vendor_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('vendor_form', array('legend'=>Mage::helper('framecontract')->__('Vendor information')));
     
     if(Mage::helper('core')->isModuleEnabled('Egovs_Isolation')){
	      $fieldset->addField('store_group', 'select', array(
	      		'label' => Mage::helper('catalog')->__('Store'),
	      		'title' => Mage::helper('catalog')->__('Store'),
	      		'name'  => 'store_group',
	      		'value' => '',
	      		'values'=> Mage::getModel('isolation/entity_attribute_source_storegroups')->getOptionArray()
	      ));
     }
      
      $fieldset->addField('company', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Company'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'company',
      ));
      
     $fieldset->addField('operator', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Operator'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'operator',
      ));
      
     $fieldset->addField('order_email', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Order EMail'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'order_email',
      ));
     
     $fieldset->addField('claim_email', 'text', array(
     		'label'     => Mage::helper('framecontract')->__('Claim EMail'),
     		//'class'     => 'required-entry',
     		//'required'  => true,
     		'name'      => 'claim_email',
     ));
      
      $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('framecontract')->__('General EMail'),
      	  'width'	  => '80px',	
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'email',
      ));
      
      $fieldset->addField('street', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Street'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'street',
      ));
      
     $fieldset->addField('city', 'text', array(
          'label'     => Mage::helper('framecontract')->__('City'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'city',
      ));
      
      $fieldset->addField('plz', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Postcode'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'plz',
      ));
      
     $fieldset->addField('fax', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Fax'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'fax',
      ));
      
     $fieldset->addField('tel', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Telephone'),
          ///'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'tel',
      ));
      
     $fieldset->addField('country', 'text', array(
          'label'     => Mage::helper('framecontract')->__('Country'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'country',
      ));
     
     $fieldset->addField('u4_main_apar_id', 'text', array(
     		'label'     => Mage::helper('framecontract')->__('Agresso BW Lieferantennummer'),
     		//'class'     => 'required-entry',
     		//'required'  => true,
     		'name'      => 'u4_main_apar_id',
     ));

      if ( Mage::getSingleton('adminhtml/session')->getFramecontractData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getFramecontractData());
          Mage::getSingleton('adminhtml/session')->setFramecontractData(null);
      } elseif ( Mage::registry('vendor_data') ) {
          $form->setValues(Mage::registry('vendor_data')->getData());
      }
      return parent::_prepareForm();
  }
}