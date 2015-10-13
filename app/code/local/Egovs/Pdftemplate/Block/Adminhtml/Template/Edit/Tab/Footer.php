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
class Egovs_Pdftemplate_Block_Adminhtml_Template_Edit_Tab_Footer extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('template_marginal', array('legend'=>Mage::helper('pdftemplate')->__('Footer')));
     
     $fieldset->addField('footer_pdftemplate_section_id', 'hidden', array(
           'name'      => 'footer[pdftemplate_section_id]',
      ));
      
     $fieldset->addField('footer_top', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Top'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'footer[top]',
     	  'value'     => '0',
      ));
      
      $fieldset->addField('footer_left', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Left'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'footer[left]',
      	  'value'     => '0',
      ));

      $fieldset->addField('footer_width', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Width'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'footer[width]',
      	  'value'     => '0',
      ));
      
      $fieldset->addField('footer_height', 'text', array(
          'label'     => Mage::helper('pdftemplate')->__('Height'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'footer[height]',
      	  'value'     => '0',
      ));
      
      $fieldset->addField('footer_occurrence', 'select', array(
          'label'     => Mage::helper('pdftemplate')->__('Occurrence'),
          'name'      => 'footer[occurrence]',
      	  'values'    => Egovs_Pdftemplate_Model_Occurrence::getOptionArray(),
      ));
      
      
      $fieldset->addField('footer_content', 'editor', array(
          'label'     => Mage::helper('pdftemplate')->__('Content'),
      	  'style'     => 'width:725px;height:460px',
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'footer[content]',
        ));

     
        
       /* 
      if ( Mage::registry('template_data'))
      {
      	  $data = Mage::registry('template_data')->getData();
          $form->setValues($data);
          //Mage::getSingleton('adminhtml/session')->setPdftemplateData(null);
      } elseif ( Mage::registry('template_data') ) {
          //$form->setValues(Mage::registry('template_data')->getData());
      }
      */
        
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