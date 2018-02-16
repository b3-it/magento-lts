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
      $fieldset = $form->addFieldset('toll_entity_form', array('legend'=>Mage::helper('bkg_tollpolicy')->__('Toll')));
      
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
      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      $fieldset->addField('date_from', 'date', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('From'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'date_from',
          'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
          'image'  => $this->getSkinUrl('images/grid-cal.gif'),
          'format'       => $dateFormatIso
      ));
      $fieldset->addField('date_to', 'date', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('To'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'date_to',
          'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
          'image'  => $this->getSkinUrl('images/grid-cal.gif'),
          'format'       => $dateFormatIso
      ));

      $values = Mage::getModel('bkg_tollpolicy/tollcategory')->getCollection()->toOptionArray();
      $fieldset->addField('toll_category_id', 'select', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('Category'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'toll_category_id',
      		'values' => $values
      ));
      
      $values = array();
      
      $fieldset->addField('abrechnung_int', 'multiselect', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('abrechnung_int'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'abrechnung_int',
      		'values' => $values
      ));
      
      $fieldset->addField('abrechnung_ext', 'multiselect', array(
      		'label'     => Mage::helper('bkg_tollpolicy')->__('abrechnung_ext'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'abrechnung_ext',
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
