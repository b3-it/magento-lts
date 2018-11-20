<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Block_Adminhtml_Usetypeentity_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Block_Adminhtml_Usetype_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
        return parent::_prepareForm();
    }

  protected function x_prepareForm()
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
      $fieldset = $form->addFieldset('use_type_entity_form', array('legend'=>Mage::helper('bkg_tollpolicy')->__('Type of Use')));
      
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
      $fieldset->addField('active', 'select', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Active'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'active',
          'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
      ));
      $fieldset->addField('internal', 'select', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Internal'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'internal',
          'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
      ));
      $fieldset->addField('external', 'select', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('External'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'external',
          'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
      ));

      $fieldset->addField('is_default', 'select', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('is Default'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'is_default',
          'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
      ));
      $values = Mage::getModel('bkg_tollpolicy/toll')->getCollection()->toOptionArray();
      $fieldset->addField('toll_id', 'select', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Toll'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'toll_id',
      		'values' => $values
      ));
      $fieldset->addField('pos', 'text', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Pos'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'pos',
      ));
      
      
      
      if ( Mage::getSingleton('adminhtml/session')->getuse_type_entityData() )
      {
      	$form->setValues(Mage::getSingleton('adminhtml/session')->getuse_type_entityData());
      	Mage::getSingleton('adminhtml/session')->setuse_type_entityData(null);
      } elseif ( Mage::registry('use_type_entity_data') ) {
      	$form->setValues(Mage::registry('use_type_entity_data')->getData());
      }
      return parent::_prepareForm();
  }
}
