<?php
/**
 * Verwalten von Dokumenten im Webshop.
 *
 * @category	Egovs
 * @package		Egovs_Doc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Doc_Block_Adminhtml_Doc_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('doc_form', array('legend'=>Mage::helper('egovs_doc')->__('Documentdetails')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('egovs_doc')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
      	  'width' 		=> '200px',
          'name'      => 'title',
      ));
      
      $fieldset->addField('description', 'text', array(
      		'label'     => Mage::helper('egovs_doc')->__('Description'),
      		
      		'name'      => 'description',
      ));
      
      $fieldset->addField('category', 'select', array(
      		'label'     => Mage::helper('egovs_doc')->__('Category'),
      		'values'    => Egovs_Doc_Model_Category::getOptionArray(),
      		'name'      => 'category',
      		
      ));

      $fieldset->addField('filename', 'text', array(
          'label'     => Mage::helper('egovs_doc')->__('Existing File'),
           'readonly'  => true,
      	  'disabled' => true,
          'class'	 => 'readonly',
          'name'      => 'filename',
	  ));
      
      $fieldset->addField('upfilename', 'file', array(
      		'label'     => Mage::helper('egovs_doc')->__('New File'),
      		'required'  => false,
      		'name'      => 'upfilename',
      ));
		
    
      $afterElementHtml = '<p class="nm"><small>' .  Mage::helper('egovs_doc')->__('maximum 1024 character') . '</small></p>';
      
   
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('egovs_doc')->__('Content'),
          'title'     => Mage::helper('egovs_doc')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
      	  'after_element_html' => $afterElementHtml,
          
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getDocData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getDocData());
          Mage::getSingleton('adminhtml/session')->setDocData(null);
      } elseif ( Mage::registry('doc_data') ) {
          $form->setValues(Mage::registry('doc_data')->getData());
      }
      return parent::_prepareForm();
  }
}