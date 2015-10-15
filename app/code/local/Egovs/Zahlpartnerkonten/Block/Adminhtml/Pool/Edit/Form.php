<?php

class Egovs_Zahlpartnerkonten_Block_Adminhtml_Pool_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);
      $fieldset = $form->addFieldset('pool_form', array('legend'=>Mage::helper('zpkonten')->__('Item information')));
     
      $fieldset->addField('kassenzeichen', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Kassenzeichen'),
          'disabled'	=>true,
          'name'      => 'kassenzeichen',
      ));

      $fieldset->addField('mandant', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Mandant'),
          'disabled'	=>true,
          'name'      => 'mandant',
      ));
      
      
     $fieldset->addField('bewirtschafter', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Bewirtschafter'),
          'disabled'	=>true,
          'name'      => 'bewirtschafter',
      ));
      
      
     $fieldset->addField('customer_id', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Customer#'),
          'disabled'	=>true,
          'name'      => 'customer_id',
      ));
      
      
     $fieldset->addField('customer_name', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Name'),
          'disabled'	=>true,
          'name'      => 'customer_name',
      ));
      
     $fieldset->addField('customer_company', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Company'),
          'disabled'	=>true,
          'name'      => 'customer_company',
      ));
      
     $fieldset->addField('customer_street', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Street'),
          'disabled'	=>true,
          'name'      => 'customer_street',
      ));
      
	 $fieldset->addField('customer_postcode', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Postcode'),
          'disabled'	=>true,
          'name'      => 'customer_postcode',
      ));

	 $fieldset->addField('last_payment', 'select', array(
          'label'     => Mage::helper('zpkonten')->__('Last Payment Method'),
          'disabled'	=>true,
          'name'      => 'last_payment',
	 	  'values'	  => Mage::helper('paymentbase')->getActivePaymentMethods(),
      ));
      
      $fieldset->addField('currency', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Currency'),
          'disabled'	=>true,
          'name'      => 'currency',
      ));
      
      $fieldset->addField('comment', 'textarea', array(
      		'label'     => Mage::helper('zpkonten')->__('Comment for Status'),
      		'class'		=> 'validate-length-1024',
      		'name'      => 'comment',
      ));
      
      $st = Egovs_Zahlpartnerkonten_Model_Status::getOptionArray();
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('zpkonten')->__('Status'),
          'name'      => 'status',
          'values'    => $st
      ));
		
      if ( Mage::getSingleton('adminhtml/session')->getZahlpartnerkontenData() ) {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getZahlpartnerkontenData());
          Mage::getSingleton('adminhtml/session')->setZahlpartnerkontenData(null);
      } elseif ( Mage::registry('pool_data') ) {
          $form->setValues(Mage::registry('pool_data')->getData());
      }
      return parent::_prepareForm();
  }
}