<?php
/**
 *
 *  Edit Formular für pdf Template
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Block_Adminhtml_Template_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('template_form', array('legend'=>Mage::helper('pdftemplate')->__('Template')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'general[title]',
      ));

      $fieldset->addField('description', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Description'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'general[description]',
        ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('pdftemplate')->__('Status'),
          'name'      => 'general[status]',
          'values'    => Egovs_Pdftemplate_Model_Status::getOptionArray(),
      ));
      
     $fieldset->addField('type', 'select', array(
          'label'     => Mage::helper('pdftemplate')->__('Typ'),
          'name'      => 'general[type]',
          'values'    => Egovs_Pdftemplate_Model_Type::getOptionArray(),
      ));
      
      $fieldset->addField('font', 'select', array(
          'label'     => Mage::helper('pdftemplate')->__('Font'),
          'name'      => 'general[font]',
          'values'    => Egovs_Pdftemplate_Model_Font::getOptionArray(),
      ));
      
     $fieldset->addField('fontsize', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Font Size'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'general[fontsize]',
     	  'value'	  => '10'
        ));
      
      if ( Mage::getSingleton('adminhtml/session')->getPdftemplateData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getPdftemplateData());
          Mage::getSingleton('adminhtml/session')->setPdftemplateData(null);
      } elseif ( Mage::registry('template_data') ) {
          $form->setValues(Mage::registry('template_data')->getData());
      }
      
      return parent::_prepareForm();
  }
}