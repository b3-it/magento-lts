<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Copy_Agreement_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Agreement_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('copyagreement_form', array('legend'=>Mage::helper('bkg_license')->__(' Copy Agreement information')));

      $fieldset->addField('master_id', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Muster'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'master_id',
      ));
      $fieldset->addField('identifier', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Bestellbedingungen'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'identifier',
      ));
      $fieldset->addField('pos', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Position'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'pos',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getcopyagreementData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getcopyagreementData());
          Mage::getSingleton('adminhtml/session')->setcopyagreementData(null);
      } elseif ( Mage::registry('copyagreement_data') ) {
          $form->setValues(Mage::registry('copyagreement_data')->getData());
      }
      return parent::_prepareForm();
  }
}
