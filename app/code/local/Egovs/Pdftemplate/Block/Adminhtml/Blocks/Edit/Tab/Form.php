<?php

/**
 *
 *  Edit Block für pdf Template-Blöcke
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Egovs_Pdftemplate_Block_Adminhtml_Blocks_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('blocks_form', array('legend'=>Mage::helper('pdftemplate')->__('Item information')));
     
      $fieldset->addField('ident', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Identifier'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'ident',
      ));
      
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      


      
      $payment = Mage::getModel('adminhtml/system_config_source_payment_allowedmethods')->toOptionArray();
      array_shift($payment);
      $payment = array_merge(array(array('label' => Mage::helper('pdftemplate')->__('All Payment Methods'),'value'=>'all')), $payment);
      $fieldset->addField('payment', 'select', array(
          'label'     => Mage::helper('pdftemplate')->__('Payment Method'),
//         'class'     => 'required-entry',
//         'required'  => true,
          'name'      => 'payment',
      	  'values'	  => $payment,
      	  //'note'   => $this->__('Leave empty for default'),
      ));
      
      
      $shippment = Mage::getModel('adminhtml/system_config_source_shipping_allowedmethods')->toOptionArray();
      array_shift($shippment);
      $shippment = array_merge(array(array('label' => Mage::helper('pdftemplate')->__('All Shipping Methods'),'value'=>'all')), $shippment);
      $fieldset->addField('shipping', 'select', array(
          'label'     => Mage::helper('pdftemplate')->__('Shipping Method'),
//         'class'     => 'required-entry',
//         'required'  => true,
          'name'      => 'shipping',
      	  'values'	  => $shippment,
      ));
      

     $tax = Mage::getModel('pdftemplate/system_config_source_taxRules')->toOptionArray();
     // array_shift($shippment);
      $tax = array_merge(array(array('label' => Mage::helper('pdftemplate')->__('All Tax Rules'),'value'=>'all')), $tax);
      $fieldset->addField('tax_rule', 'select', array(
      		'label'     => Mage::helper('pdftemplate')->__('Tax Rules'),
      		//         'class'     => 'required-entry',
      //         'required'  => true,
      		'name'      => 'tax_rule',
      		'values'	  => $tax,
      ));
      
      
/*
     $groups = Mage::getModel('customer/group')->getCollection();  
     $fieldset->addField('customer_group_id', 'select', array(
          'label'     => Mage::helper('paymentbase')->__('Customer Group'),
//           'class'     => 'required-entry',
//           'required'  => true,
          'name'      => 'customer_group_id',
     	  'values'	  => array_merge(array(array('label' => Mage::helper('paymentbase')->__('All Customer Groups'),'value'=>'-1')), $groups->toOptionArray()),
     	  //'note'   => $this->__('Leave empty for default'),
     	
      ));
*/		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('pdftemplate')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => Egovs_Pdftemplate_Model_Blocks_Status::STATUS_ENABLED,
                  'label'     => Mage::helper('pdftemplate')->__('Enabled'),
              ),

              array(
                  'value'     => Egovs_Pdftemplate_Model_Blocks_Status::STATUS_DISABLED,
                  'label'     => Mage::helper('pdftemplate')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('pdftemplate')->__('Content'),
          'title'     => Mage::helper('pdftemplate')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getPdftemplateData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getPdftemplateData());
          Mage::getSingleton('adminhtml/session')->setPdftemplateData(null);
      } elseif ( Mage::registry('blocks_data') ) {
          $form->setValues(Mage::registry('blocks_data')->getData());
      }
      return parent::_prepareForm();
  }
}