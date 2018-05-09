<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Block_Adminhtml_Queue_Rule_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Block_Adminhtml_Queue_Rule_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('queuerule_form', array('legend'=>Mage::helper('b3it_mq')->__(' Queue Rule information')));

      $fieldset->addField('ruleset_id', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Rule'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'ruleset_id',
      ));
      $fieldset->addField('condition', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Condition'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'condition',
      ));
      $fieldset->addField('lagical_operand', 'text', array(
          'label'     => Mage::helper('b3it_mq')->__('Logical Operand'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'lagical_operand',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getqueueruleData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getqueueruleData());
          Mage::getSingleton('adminhtml/session')->setqueueruleData(null);
      } elseif ( Mage::registry('queuerule_data') ) {
          $form->setValues(Mage::registry('queuerule_data')->getData());
      }
      return parent::_prepareForm();
  }
}
