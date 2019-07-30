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
class Egovs_Pdftemplate_Block_Adminhtml_Template_Edit_Tab_Body extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('template_body', array('legend'=>Mage::helper('pdftemplate')->__('Body')));
     
     $fieldset->addField('body_pdftemplate_section_id', 'hidden', array(
          'name'      => 'body[pdftemplate_section_id]',
      ));
      
     $fieldset->addField('body_top', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Top'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'body[top]',
     	  'value'     => '0',
      ));
      
      $fieldset->addField('body_left', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Left'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'body[left]',
      	  'value'     => '0',
      ));

      $fieldset->addField('body_width', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Width'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'body[width]',
      	  'value'     => '0',
      ));
      
      $fieldset->addField('body_height', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Height'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'body[height]',
      	  'value'     => '0',
      ));
      
      $fieldset->addField('body_content', 'editor', array(
          'label'     => Mage::helper('pdftemplate')->__('Content'),
      	  'style'     => 'width:725px;height:460px',
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'body[content]',
        ));


      if ( Mage::getSingleton('adminhtml/session')->getPdftemplateData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getPdftemplateData());
          Mage::getSingleton('adminhtml/session')->setPdftemplateData(null);
      } elseif ( Mage::registry('template_data') ) {
      		$data = Mage::registry('template_data')->getData();
      		if(count($data) > 0) $form->setValues($data);
      }
      
      return parent::_prepareForm();
  }
}