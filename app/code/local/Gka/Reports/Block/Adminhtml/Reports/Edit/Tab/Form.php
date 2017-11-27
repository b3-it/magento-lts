<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Gka
 *  @package  Gka_Reports
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_Reports_Block_Adminhtml_Reports_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('reports_form', array('legend'=>Mage::helper('reports')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('reports')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('reports')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('reports')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('reports')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('reports')->__('Disabled'),
              ),
          ),
      ));
     
      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('reports')->__('Content'),
          'title'     => Mage::helper('reports')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getReportsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getReportsData());
          Mage::getSingleton('adminhtml/session')->setReportsData(null);
      } elseif ( Mage::registry('reports_data') ) {
          $form->setValues(Mage::registry('reports_data')->getData());
      }
      return parent::_prepareForm();
  }
}