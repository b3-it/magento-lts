<?php
/**
 * Sid ExportOrder
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Block_Adminhtml_Export_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Block_Adminhtml_Export_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	
	
	
	
	
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('export_form', array('legend'=>Mage::helper('exportorder')->__('Order information')));

      $order = Mage::registry('order');
      $contract = Mage::getModel('framecontract/contract')->load($order->getFramecontract());
      $vendor = Mage::getModel('framecontract/vendor')->load($contract->getFramecontractVendorId());
      $address = Mage::getModel('sales/order_address')->load($order->getBillingAddressId());
      
      $fieldset->addField('increment_id', 'text', array(
          'label'     => Mage::helper('exportorder')->__('Order#'),
          'class'     => 'disabled',
          'disabled'  => true,
          'name'      => 'increment_id',
      	  'value'	=> $order->getIncrementId()
      ));

      $fieldset->addField('adr', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Billingaddress'),
      		'class'     => 'disabled',
      		'disabled'  => true,
      		'name'      => 'adr',
      		'value'	=>  sprintf('%s %s %s', $address->getFirstname(), $address->getLastname(), $address->getCompany()),
      ));
      
      $fieldset->addField('contract', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Contract'),
      		'class'     => 'disabled',
      		'disabled'  => true,
      		'name'      => 'contract',
      		'value'	=>  $contract->getTitle(),
      ));
      
      $fieldset->addField('vendor', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Vendor'),
      		'class'     => 'disabled',
      		'disabled'  => true,
      		'name'      => 'vendor',
      		'value'	=>  $vendor->getCompany(),
      ));
      
      $fieldset->addField('email', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Email'),
      		'class'     => 'disabled',
      		'disabled'  => true,
      		'name'      => 'email',
      		'value'	=>  $vendor->getOrderEmail(),
      ));
      
      
      $fieldset->addField('format', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Format'),
      		'class'     => 'disabled',
      		'disabled'  => true,
      		'name'      => 'format',
      		'value'	=>  $vendor->getExportFormat(),
      ));
      
      $fieldset->addField('transfer', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Transfer'),
      		'class'     => 'disabled',
      		'disabled'  => true,
      		'name'      => 'transfer',
      		'value'	=>  $vendor->getTransferType(),
      ));

     
      return parent::_prepareForm();
  }
}
