<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Block_Adminhtml_Tollentity_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Block_Adminhtml_Toll_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
      $fieldset = $form->addFieldset('toll_entity_form', array('legend'=>Mage::helper('bkg_tollpolicy')->__(' Tollentity information')));
      
      $fieldset->addField('name', 'text', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Name'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'name',
      ));
      $fieldset->addField('active', 'text', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Active'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'active',
      ));
      $fieldset->addField('date_from', 'text', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('From'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'date_from',
      ));
      $fieldset->addField('date_to', 'text', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('To'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'date_to',
      ));
      $fieldset->addField('code', 'text', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Code'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'code',
      ));
      $values = Mage::getModel('bkg_tollpolicy/tollcategory')->getCollection()->toOptionArray();
      $fieldset->addField('toll_category_id', 'select', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Category'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'toll_category_id',
      		'values' => $values
      ));
      
      
      
      if ( Mage::getSingleton('adminhtml/session')->gettoll_entityData() )
      {
      	$form->setValues(Mage::getSingleton('adminhtml/session')->gettoll_entityData());
      	Mage::getSingleton('adminhtml/session')->settoll_entityData(null);
      } elseif ( Mage::registry('toll_entity_data') ) {
      	$form->setValues(Mage::registry('toll_entity_data')->getData());
      }

      return parent::_prepareForm();
  }
}
