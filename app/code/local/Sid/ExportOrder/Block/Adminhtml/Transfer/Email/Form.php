<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Sid
 *  @package  Sid_ExportOrder
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_ExportOrder_Block_Adminhtml_Transfer_Email_Form extends Mage_Adminhtml_Block_Widget_Form
{
	private $_fields = array();
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('vendor_form_transfer_details1', array('legend'=>Mage::helper('framecontract')->__('Transfer Details')));
      $fieldset->addField('email', 'text', array(
          'label'     => Mage::helper('exportorder')->__('Email'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'transfer[email]',
      ));
      
      $templates = Mage::getModel('adminhtml/system_config_source_email_template');
      $fieldset->addField('template', 'select', array(
      		'label'     => Mage::helper('exportorder')->__('Email Template'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'transfer[template]',
      		'values' =>$templates->toOptionArray()
      ));

      $data = Mage::registry('transfer')->getData();
      if(empty($data['template'])){
      	$data['template'] = 'exportorder_vendor_order_plain';
      }
      $form->setValues($data);
      return parent::_prepareForm();
  }
}