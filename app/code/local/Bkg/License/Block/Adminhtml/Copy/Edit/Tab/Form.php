<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Copy_Entity_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('copyentity_form', array('legend'=>Mage::helper('bkg_license')->__(' Copy Entity information')));

      $fieldset->addField('usetypeoption_id', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Nutzungsart'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'usetypeoption_id',
      ));
      $fieldset->addField('customergroup_id', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Kundengruppe'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'customergroup_id',
      ));
      $fieldset->addField('type', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Lizenztyp'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'type',
      ));
      $fieldset->addField('reuse', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Nchnutzung'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'reuse',
      ));
      $fieldset->addField('ident', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Lizenznummer'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'ident',
      ));
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'name',
      ));
      $fieldset->addField('date_from', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Anfangsdatum'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'date_from',
      ));
      $fieldset->addField('date_to', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Enddatum'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'date_to',
      ));
      $fieldset->addField('active', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Aktiv'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'active',
      ));
      $fieldset->addField('consternation_check', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Betroffenheit prüfen'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'consternation_check',
      ));
      $fieldset->addField('master_id', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Muster'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'master_id',
      ));
      $fieldset->addField('product_id', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Produkt'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'product_id',
      ));
      $fieldset->addField('customer_id', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Kunde'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'customer_id',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getcopyentityData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getcopyentityData());
          Mage::getSingleton('adminhtml/session')->setcopyentityData(null);
      } elseif ( Mage::registry('copyentity_data') ) {
          $form->setValues(Mage::registry('copyentity_data')->getData());
      }
      return parent::_prepareForm();
  }
}
