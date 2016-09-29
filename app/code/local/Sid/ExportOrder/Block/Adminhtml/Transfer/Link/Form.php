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
class Sid_ExportOrder_Block_Adminhtml_Transfer_Link_Form extends Mage_Adminhtml_Block_Widget_Form
{
	private $_fields = array();
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      //$fieldset = $form->addFieldset('vendor_form_format_details', array('legend'=>Mage::helper('exportorder')->__('Item information')));
     
      $form->addField('email', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Email'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'transfer[email]',
      ));
      
      $form->addField('cron', 'text', array(
      		'label'     => Mage::helper('exportorder')->__('Cron Expression'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'transfer[cron]',
      		'after_element_html'	=> '<span> * * * * * (Minute Stunde Monatstag Monat Wochentag) </span>'
      ));
      
      $templates = Mage::getModel('adminhtml/system_config_source_email_template');
      $form->addField('template', 'select', array(
      		'label'     => Mage::helper('exportorder')->__('Email Template'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'transfer[template]',
      		'values' =>$templates->toOptionArray()
      ));
 
      $form->setValues(Mage::registry('transfer')->getData());
      return parent::_prepareForm();
  }
}