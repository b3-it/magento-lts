<?php
/**
 * Egovs Infoletter
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter_Block_Adminhtml_Queue_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Infoletter_Block_Adminhtml_Queue_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('queue_form', array('legend'=>Mage::helper('infoletter')->__('Queue information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('infoletter')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      
      $fieldset->addField('sender_name', 'text', array(
      		'label'     => Mage::helper('infoletter')->__('Sender Name'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'sender_name',
      ));
      
      $fieldset->addField('sender_email', 'text', array(
      		'label'     => Mage::helper('infoletter')->__('Sender Email'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'sender_email',
      ));
      
      $fieldset->addField('message_subject', 'text', array(
      		'label'     => Mage::helper('infoletter')->__('Subject'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'message_subject',
      ));

      
 		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('infoletter')->__('Status'),
          'name'      => 'status',
          'values'    => Egovs_Infoletter_Model_Status::getAllOptions(),
      	  'disabled' => true,
      	  'class'	=> 'readonly' 	
      ));
     
      $model = Mage::registry('queue_data') ;
      
      
      $widgetFilters = array('is_email_compatible' => 1);
      $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('widget_filters' => $widgetFilters));
     
      $wysiwygConfig->setEnabled(true);
      $wysiwygConfig->setAddWidgets(false);
      $wysiwygConfig->setAddVariables(true);
      $wysiwygConfig->setAddImages(false);
      
      $fieldset->addField('message_body', 'editor', array(
      		'name'      => 'message_body',
      		'label'     => Mage::helper('infoletter')->__('Message Body Html'),
      		'title'     => Mage::helper('infoletter')->__('Message Body Html'),
      		'required'  => true,
      		'state'     => 'html',
      		'style'     => 'height:36em;',
      		'value'     => $model->getMessageBody(),
      		'config'    => $wysiwygConfig,
      		//'use_container' =>false,
      ));
      
      $fieldset->addField('message_body_plain', 'editor', array(
      		'name'      => 'message_body_plain',
      		'label'     => Mage::helper('infoletter')->__('Message Body Plain'),
      		'title'     => Mage::helper('infoletter')->__('Message Body Plain'),
      		'required'  => true,
      		//'state'     => 'html',
      		'style'     => 'height:36em;',
      		'value'     => $model->getMessageBodyPlain(),
      		//'config'    => $wysiwygConfig,
      		//'use_container' =>false,
      ));
      
     
     
      if ( Mage::getSingleton('adminhtml/session')->getInfoletterData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getInfoletterData());
          Mage::getSingleton('adminhtml/session')->setInfoletterData(null);
      } elseif ( Mage::registry('queue_data') ) {
          $form->setValues(Mage::registry('queue_data')->getData());
      }
      return parent::_prepareForm();
  }
  
  private function getIsPalin($model)
  {
  		$found =  preg_match("#^</*>#", $model->getMessageBody());
  		return !( $found===1);
  }
}