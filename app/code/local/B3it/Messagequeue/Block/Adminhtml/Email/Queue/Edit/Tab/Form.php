<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Block_Adminhtml_Email_Queue_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Block_Adminhtml_Email_Queue_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('emailqueue_form', array('legend'=>Mage::helper('b3it_mq')->__(' Email Queue information')));




      if ( Mage::getSingleton('adminhtml/session')->getemailqueueData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getemailqueueData());
          Mage::getSingleton('adminhtml/session')->setemailqueueData(null);
      } elseif ( Mage::registry('emailqueue_data') ) {
          $form->setValues(Mage::registry('emailqueue_data')->getData());
      }
      return parent::_prepareForm();
  }
}
