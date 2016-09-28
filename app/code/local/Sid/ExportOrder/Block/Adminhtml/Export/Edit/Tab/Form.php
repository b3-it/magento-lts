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
      $fieldset = $form->addFieldset('export_form', array('legend'=>Mage::helper('exportorder')->__('Item information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('exportorder')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('exportorder')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));

      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('exportorder')->__('Status'),
          'name'      => 'status',
          'values'    => Sid_ExportOrder_Model_Status::getAllOptions(),
      ));

      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('exportorder')->__('Content'),
          'title'     => Mage::helper('exportorder')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));

      if ( Mage::getSingleton('adminhtml/session')->getExportOrderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getExportOrderData());
          Mage::getSingleton('adminhtml/session')->setExportOrderData(null);
      } elseif ( Mage::registry('export_data') ) {
          $form->setValues(Mage::registry('export_data')->getData());
      }
      return parent::_prepareForm();
  }
}
