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
class Sid_ExportOrder_Block_Adminhtml_Format_Plain_Form extends Mage_Adminhtml_Block_Widget_Form
{
	private $_fields = array();
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      //$fieldset = $form->addFieldset('vendor_form_format_details', array('legend'=>Mage::helper('exportorder')->__('Item information')));
     
      $form->addField('title', 'text', array(
          'label'     => Mage::helper('exportorder')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

    
      if ( Mage::getSingleton('adminhtml/session')->getExportOrderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getExportOrderData());
          Mage::getSingleton('adminhtml/session')->setExportOrderData(null);
      } elseif ( Mage::registry('exportorder_data') ) {
          $form->setValues(Mage::registry('exportorder_data')->getData());
      }
      return parent::_prepareForm();
  }
}