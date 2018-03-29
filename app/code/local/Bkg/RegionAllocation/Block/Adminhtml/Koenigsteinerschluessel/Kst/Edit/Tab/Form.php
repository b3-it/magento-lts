<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name       	Bkg_Regionallocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_RegionAllocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('koenigsteinerschluesselkst_form', array('legend'=>Mage::helper('regionallocation')->__('Details')));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('regionallocation')->__('Name'),
          //'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
      $fieldset->addField('active', 'select', array(
          'label'     => Mage::helper('regionallocation')->__('Active'),
          //'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'active',
      	  'values'    => Bkg_RegionAllocation_Model_Koenigsteinerschluessel_Status::getAllOptions(),
      ));
      
     
      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
      $fieldset->addField('start_date', 'date', array(
      		'label'     => Mage::helper('regionallocation')->__('Active From'),
      		'name'      => 'active_from',
      		'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
      		//'class'     => 'readonly',
      		//'readonly'  => true,
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'format'       => $dateFormatIso,
      		'image'  => $this->getSkinUrl('images/grid-cal.gif'),
      ));
      
  
      /*
      $fieldset->addField('active_to', 'text', array(
          'label'     => Mage::helper('regionallocation')->__('Active To'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'active_to',
      ));

*/

      if ( Mage::getSingleton('adminhtml/session')->getkoenigsteinerschluesselkstData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getkoenigsteinerschluesselkstData());
          Mage::getSingleton('adminhtml/session')->setkoenigsteinerschluesselkstData(null);
      } elseif ( Mage::registry('koenigsteinerschluesselkst_data') ) {
          $form->setValues(Mage::registry('koenigsteinerschluesselkst_data')->getData());
      }
      return parent::_prepareForm();
  }
}
