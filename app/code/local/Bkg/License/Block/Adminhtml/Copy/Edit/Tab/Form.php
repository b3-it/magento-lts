<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Form
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
      $fieldset = $form->addFieldset('entity_form', array('legend'=>Mage::helper('bkg_license')->__('Copy License Information')));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'name',
      ));

      $fieldset->addField('ident', 'text', array(
          'label'     => Mage::helper('bkg_license')->__('Number of License'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'ident',
      ));

      $fieldset->addField('is_orgunit', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Type Customer'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'is_orgunit',
          'values' => array(array('label'=>$this->__('Customer'),'value'=>0),
                        array('label'=>$this->__('Organisational Unit'),'value'=>1)
                        )
      ));

      $customers = array();
      $collection = Mage::getModel('customer/customer')->getCollection();

      $collection->addAttributeToSelect('*');

      $customers[] = array('label'=>'','value'=>'');
      foreach($collection as $item)
      {
          $name= "{$item->getEmail()} {$item->getFirstname()} {$item->getLastname()} {$item->getCompany()}";
          $customers[] = array('label'=>$name,'value'=>$item->getId());
      }


      $fieldset->addField('customer', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Customer'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'customer_id',
          'values' => $customers
      ));

      $collection = Mage::getModel('bkg_orgunit/unit')->getCollection();
      $units = array();
      $units[] = array('label'=>'','value'=>'');
      foreach($collection as $item)
      {
          $name= "{$item->getShortname()}";
          $units[] = array('label'=>$name,'value'=>$item->getId());
      }

      $fieldset->addField('orgunit', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Organisational Unit'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'orgunit_id',
          'values' => $units
      ));
   

      $fieldset->addField('type', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Type of License'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'type',
      		'values' => Bkg_License_Model_Type::getOptionArray()
      ));
      
      $yesno = Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray();
      
      $fieldset->addField('reuse', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Reuse'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'reuse',
      	  'values' => $yesno
      ));

      
      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      $fieldset->addField('date_from', 'date', array(
      		'label'     => Mage::helper('bkg_license')->__('Start Date'),
      		'name'      => 'date_from',
      		'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'format'       => $dateFormatIso,
      		'image'  => $this->getSkinUrl('images/grid-cal.gif'),
      ));
      
      $fieldset->addField('date_to', 'date', array(
      		'label'     => Mage::helper('bkg_license')->__('End Date'),
      		'name'      => 'date_to',
      		'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'format'       => $dateFormatIso,
      		'image'  => $this->getSkinUrl('images/grid-cal.gif'),
      ));
      
     
      $fieldset->addField('active', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Active'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'active',
      	  'values' => $yesno
      ));
      $fieldset->addField('consternation_check', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Check Consternation'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'consternation_check',
      		'values' => $yesno
      ));



      if ( Mage::getSingleton('adminhtml/session')->getentityData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getentityData());
          Mage::getSingleton('adminhtml/session')->setentityData(null);
      } elseif ( Mage::registry('entity_data') ) {
          $form->setValues(Mage::registry('entity_data')->getData());
      }

      return parent::_prepareForm();
  }
}
