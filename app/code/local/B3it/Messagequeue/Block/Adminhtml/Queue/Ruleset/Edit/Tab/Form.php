<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Block_Adminhtml_Queue_Ruleset_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Block_Adminhtml_Queue_Ruleset_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('queueruleset_form', array('legend'=>Mage::helper('b3it_mq')->__(' Queue Ruleset information')));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'name',
      ));
      
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('b3it_mq')->__('Status'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'status',
      	 'values' => B3it_Messagequeue_Model_Queue_Status::getOptionArray()
      ));
      $fieldset->addField('category', 'select', array(
          'label'     => Mage::helper('b3it_mq')->__('Category'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'category',
      	  'values'	=> Mage::getModel('b3it_mq/queue_category')->getOptionArray()
      ));
      $fieldset->addField('recipients', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Recipients'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'recipients',
      ));
      
      $fieldset->addField('sender_name', 'text', array(
      		'label'     => Mage::helper('b3it_mq')->__('Sender Name'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'sender_name',
      ));
      
      $fieldset->addField('sender_email', 'text', array(
      		'label'     => Mage::helper('b3it_mq')->__('Sender Email'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'sender_email',
      ));
      
      $fieldset->addField('owner_id', 'select', array(
          'label'     => Mage::helper('b3it_mq')->__('Owner'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'owner_id',
      	  'values'	=> Mage::getModel('b3it_mq/queue_owner')->getOptionArray()
      ));
      
      $fieldset->addField('subject', 'text', array(
      		'label'     => Mage::helper('b3it_mq')->__('Subject'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'subject',
      ));
      $fieldset->addField('template', 'textarea', array(
          'label'     => Mage::helper('b3it_mq')->__('Template'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'template',
      ));
      $fieldset->addField('template_html', 'textarea', array(
      		'label'     => Mage::helper('b3it_mq')->__('HTML Template'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'template_html',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getqueuerulesetData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getqueuerulesetData());
          Mage::getSingleton('adminhtml/session')->setqueuerulesetData(null);
      } elseif ( Mage::registry('queueruleset_data') ) {
          $form->setValues(Mage::registry('queueruleset_data')->getData());
      }
      return parent::_prepareForm();
  }
}
