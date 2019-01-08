<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Regionallocation_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Regionallocation_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('componentsregionallocation_form', array('legend'=>Mage::helper('bkg_virtualGeo')->__(' Components Regionallocation information')));

      $fieldset->addField('parent_id', 'text', array(
          'label'     => Mage::helper('bkg_virtualGeo')->__('Parent Id'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'parent_id',
      ));
      $fieldset->addField('rap_id', 'text', array(
          'label'     => Mage::helper('bkg_virtualGeo')->__(''),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'rap_id',
      ));
      $fieldset->addField('fee', 'text', array(
          'label'     => Mage::helper('bkg_virtualGeo')->__(''),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'fee',
      ));
      $fieldset->addField('usage', 'text', array(
          'label'     => Mage::helper('bkg_virtualGeo')->__(''),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'usage',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getcomponentsregionallocationData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getcomponentsregionallocationData());
          Mage::getSingleton('adminhtml/session')->setcomponentsregionallocationData(null);
      } elseif ( Mage::registry('componentsregionallocation_data') ) {
          $form->setValues(Mage::registry('componentsregionallocation_data')->getData());
      }
      return parent::_prepareForm();
  }
}
