<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Block_Adminhtml_Useoptionsentity_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Block_Adminhtml_Useoptions_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);
      $fieldset = $form->addFieldset('use_options_entity_form', array('legend'=>Mage::helper('bkg_tollpolicy')->__(' Useoptionsentity information')));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('bkg_tollpolicy')->__('Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'name',
      ));
      $fieldset->addField('code', 'text', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Code'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'code',
      ));
      $fieldset->addField('factor', 'text', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Factor'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'factor',
      ));
      $fieldset->addField('userdefined', 'text', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Userdefined'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'userdefined',
      ));
      $fieldset->addField('is_default', 'select', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('is Default'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'is_default',
          'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
      ));
      $fieldset->addField('is_calculable', 'select', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('is Calculable'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'is_calculable',
          'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
      ));
      $values = Mage::getModel('bkg_tollpolicy/usetype')->getCollection()->toOptionArray();
      $fieldset->addField('use_type_id', 'select', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Type of Use'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'use_type_id',
      		'values' => $values
      ));

      $fieldset->addField('pos', 'text', array(
          'label'     => Mage::helper('bkg_tollpolicy')->__('Pos'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'pos',
      ));
      
      if ( Mage::getSingleton('adminhtml/session')->getuse_options_entityData() )
      {
      	$form->setValues(Mage::getSingleton('adminhtml/session')->getuse_options_entityData());
      	Mage::getSingleton('adminhtml/session')->setuse_options_entityData(null);
      } elseif ( Mage::registry('use_options_entity_data') ) {
      	$form->setValues(Mage::registry('use_options_entity_data')->getData());
      }
      return parent::_prepareForm();
  }
}
