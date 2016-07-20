<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Lookup_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Lookup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('lookup_form', array('legend'=>Mage::helper('eventmanager')->__('Lookup information')));

      $fieldset->addField('value', 'text', array(
          'label'     => Mage::helper('eventmanager')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'value',
      ));

      $fieldset->addField('typ', 'select', array(
          'label'     => Mage::helper('eventmanager')->__('Typ'),
          'name'      => 'typ',
          'values'    => Bfr_EventManager_Model_Lookup_Typ::getAllOptions(),
      ));


      if ( Mage::getSingleton('adminhtml/session')->getEventManagerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEventManagerData());
          Mage::getSingleton('adminhtml/session')->setEventManagerData(null);
      } elseif ( Mage::registry('lookup_data') ) {
          $form->setValues(Mage::registry('lookup_data')->getData());
      }
      return parent::_prepareForm();
  }
}
