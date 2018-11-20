<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Block_Adminhtml_Unit_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Block_Adminhtml_Unit_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('unit_form', array('legend'=>Mage::helper('bkg_orgunit')->__('Organisation Information')));

      $fieldset->addField('shortname', 'text', array(
          'label'     => Mage::helper('bkg_orgunit')->__('Short Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'shortname',
      ));
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('bkg_orgunit')->__('Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'name',
      ));
      $fieldset->addField('company', 'text', array(
          'label'     => Mage::helper('bkg_orgunit')->__('Company'),
          //'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'company',
      ));
      $fieldset->addField('line', 'text', array(
          'label'     => Mage::helper('bkg_orgunit')->__('Industry'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'line',
      ));
      $fieldset->addField('note', 'text', array(
          'label'     => Mage::helper('bkg_orgunit')->__('Note'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'note',
      ));

      // can only be set on creation
      $id = $this->getRequest()->getParam('id');

      $fieldset->addField('parent_id', 'select', array(
          'label'     => Mage::helper('bkg_orgunit')->__('Parent Organisation'),
          // disabled and readonly if this orgunit already exist
          'disabled' => isset($id),
          'readonly' => isset($id),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'parent_id',
          'options' => Mage::getSingleton('bkg_orgunit/entity_attribute_source_unit')->getOptionArray()
      ));

      if ( Mage::getSingleton('adminhtml/session')->getunitData() ) {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getunitData());
          Mage::getSingleton('adminhtml/session')->setunitData(null);
      } elseif ( Mage::registry('unit_data') ) {
          $form->setValues(Mage::registry('unit_data')->getData());
      }

      return parent::_prepareForm();
  }
}
