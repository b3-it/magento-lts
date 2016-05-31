<?php
/**
 * Bfr EventRequest
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_Block_Adminhtml_Request_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_Block_Adminhtml_Request_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('request_form', array('legend'=>Mage::helper('eventrequest')->__('Item information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('eventrequest')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('filename', 'file', array(
          'label'     => Mage::helper('eventrequest')->__('File'),
          'required'  => false,
          'name'      => 'filename',
	  ));

      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('eventrequest')->__('Status'),
          'name'      => 'status',
          'values'    => Bfr_EventRequest_Model_Status::getAllOptions(),
      ));

      $fieldset->addField('content', 'editor', array(
          'name'      => 'content',
          'label'     => Mage::helper('eventrequest')->__('Content'),
          'title'     => Mage::helper('eventrequest')->__('Content'),
          'style'     => 'width:700px; height:500px;',
          'wysiwyg'   => false,
          'required'  => true,
      ));

      if ( Mage::getSingleton('adminhtml/session')->getEventRequestData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEventRequestData());
          Mage::getSingleton('adminhtml/session')->setEventRequestData(null);
      } elseif ( Mage::registry('request_data') ) {
          $form->setValues(Mage::registry('request_data')->getData());
      }
      return parent::_prepareForm();
  }
}
