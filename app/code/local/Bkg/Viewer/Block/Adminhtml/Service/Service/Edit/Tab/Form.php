<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Service_Service_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Service_Service_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('serviceservice_form', array('legend'=>Mage::helper('bkgviewer')->__('Item information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Title'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'title',
      ));
      $fieldset->addField('format', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Format'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'format',
      ));
      $fieldset->addField('url', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Url'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'url',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getserviceserviceData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getserviceserviceData());
          Mage::getSingleton('adminhtml/session')->setserviceserviceData(null);
      } elseif ( Mage::registry('serviceservice_data') ) {
          $form->setValues(Mage::registry('serviceservice_data')->getData());
      }
      return parent::_prepareForm();
  }
}
