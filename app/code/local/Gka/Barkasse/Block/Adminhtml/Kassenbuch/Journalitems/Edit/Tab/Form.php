<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journal_items_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journalitems_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('kassenbuchjournal_items_form', array('legend'=>Mage::helper('gka_barkasse')->__(' Kassenbuch Journalitems information')));

      $fieldset->addField('number', 'text', array(
          'label'     => Mage::helper('gka_barkasse')->__('Nubmer'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'number',
      ));
      $fieldset->addField('booking_date', 'text', array(
          'label'     => Mage::helper('gka_barkasse')->__('Booking Date'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'booking_date',
      ));
      $fieldset->addField('booking_amount', 'text', array(
          'label'     => Mage::helper('gka_barkasse')->__('Booking Amount'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'booking_amount',
      ));
      $fieldset->addField('journal_id', 'text', array(
          'label'     => Mage::helper('gka_barkasse')->__('Journal ID'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'journal_id',
      ));
      $fieldset->addField('order_id', 'text', array(
          'label'     => Mage::helper('gka_barkasse')->__('Order ID'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'order_id',
      ));
      $fieldset->addField('order_cancel', 'text', array(
          'label'     => Mage::helper('gka_barkasse')->__('Cancel'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'order_cancel',
      ));
      $fieldset->addField('source', 'text', array(
          'label'     => Mage::helper('gka_barkasse')->__('Source'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'source',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getkassenbuchjournal_itemsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getkassenbuchjournal_itemsData());
          Mage::getSingleton('adminhtml/session')->setkassenbuchjournal_itemsData(null);
      } elseif ( Mage::registry('kassenbuchjournal_items_data') ) {
          $form->setValues(Mage::registry('kassenbuchjournal_items_data')->getData());
      }
      return parent::_prepareForm();
  }
}
