<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Block_Adminhtml__Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Block_Adminhtml__Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('_form', array('legend'=>Mage::helper('bkg_orgUnit')->__('  information')));




      if ( Mage::getSingleton('adminhtml/session')->getData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getData());
          Mage::getSingleton('adminhtml/session')->setData(null);
      } elseif ( Mage::registry('_data') ) {
          $form->setValues(Mage::registry('_data')->getData());
      }
      return parent::_prepareForm();
  }
}
