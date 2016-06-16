<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Translate_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Translate_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('translate_form', array('legend'=>Mage::helper('eventmanager')->__('Details')));

      $fieldset->addField('lang_code', 'select', array(
      		'label'     => Mage::helper('eventmanager')->__('Event Language'),
      		'name'      => 'lang_code',
      		'required'  => true,
      		'values'    => Bfr_EventManager_Model_Event_Lang::getAllOptions(),
      ));
      
      
      $fieldset->addField('field', 'select', array(
      		'label'     => Mage::helper('eventmanager')->__('Field'),
      		'name'      => 'field',
      		'required'  => true,
      		'values'    => Egovs_EventBundle_Model_Personal_Fields::getAllOptions(),
      ));
      
      $fieldset->addField('source', 'text', array(
          'label'     => Mage::helper('eventmanager')->__('Source'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'source',
      ));

      $fieldset->addField('dest', 'text', array(
      		'label'     => Mage::helper('eventmanager')->__('Destination'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'dest',
      ));



 

      if ( Mage::getSingleton('adminhtml/session')->getEventManagerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEventManagerData());
          Mage::getSingleton('adminhtml/session')->setEventManagerData(null);
      } elseif ( Mage::registry('translate_data') ) {
          $form->setValues(Mage::registry('translate_data')->getData());
      }
      return parent::_prepareForm();
  }
}
