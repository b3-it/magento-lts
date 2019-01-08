<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Block_Adminhtml_Queue_Message_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Block_Adminhtml_Queue_Message_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('queuemessage_form', array('legend'=>Mage::helper('b3it_mq')->__(' Queue Message information')));

      $fieldset->addField('ruleset_id', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Rule'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'ruleset_id',
      ));
      $fieldset->addField('owner', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Owner'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'owner',
      ));
      $fieldset->addField('text', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Text'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'text',
      ));
      $fieldset->addField('recipients', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Recipients'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'recipients',
      ));
      $fieldset->addField('created_at', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Created At'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'created_at',
      ));
      $fieldset->addField('event', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Event'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'event',
      ));
      $fieldset->addField('category', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Category'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'category',
      ));
      $fieldset->addField('processed_at', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Processed At'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'processed_at',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getqueuemessageData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getqueuemessageData());
          Mage::getSingleton('adminhtml/session')->setqueuemessageData(null);
      } elseif ( Mage::registry('queuemessage_data') ) {
          $form->setValues(Mage::registry('queuemessage_data')->getData());
      }
      return parent::_prepareForm();
  }
}
