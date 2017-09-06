<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Service_Crs_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Service_Crs_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('servicecrs_form', array('legend'=>Mage::helper('bkgviewer')->__('Item information')));




      if ( Mage::getSingleton('adminhtml/session')->getservicecrsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getservicecrsData());
          Mage::getSingleton('adminhtml/session')->setservicecrsData(null);
      } elseif ( Mage::registry('servicecrs_data') ) {
          $form->setValues(Mage::registry('servicecrs_data')->getData());
      }
      return parent::_prepareForm();
  }
}
