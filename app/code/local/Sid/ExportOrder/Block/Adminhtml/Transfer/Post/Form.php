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
class Sid_ExportOrder_Block_Adminhtml_Transfer_Post_Form extends Mage_Adminhtml_Block_Widget_Form
{
	private $_fields = array();
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('vendor_form_transfer_details1', array('legend'=>Mage::helper('framecontract')->__('Transfer Details')));
      $fieldset->addField('address', 'text', array(
          'label'     => Mage::helper('exportorder')->__('Address'),
          'class'     => 'required-entry input-text',
          'required'  => true,
          'name'      => 'transfer[address]',
      ));
      
      $fieldset->addField('port', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Port'),
      		'class'     => 'input-text',
      		'name'      => 'transfer[port]',
      ));      
      
      $fieldset->addField('user', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Username'),
      		'class'     => 'input-text',
      		'name'      => 'transfer[user]',
      ));
      
      $fieldset->addField('pwd', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Password'),
      		'class'     => 'input-text',
      		'name'      => 'transfer[pwd]',
      ));
      /*
      $form->addField('field', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Field'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'transfer[field]',
      		'value'     => 'file'
      ));
		*/
      
      $form->setValues(Mage::registry('transfer')->getData());
      return parent::_prepareForm();
  }
}