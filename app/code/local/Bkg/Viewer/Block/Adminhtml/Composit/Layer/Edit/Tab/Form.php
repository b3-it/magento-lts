<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Composit_Layer_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Composit_Layer_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('compositlayer_form', array('legend'=>Mage::helper('bkgviewer')->__('Item information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Title'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'title',
      ));
      $fieldset->addField('parent_id', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Parent'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'parent_id',
      ));
      $fieldset->addField('composit_id', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Composit'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'composit_id',
      ));
      $fieldset->addField('pos', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Position'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'pos',
      ));
      $fieldset->addField('service_layer', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Layer'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'service_layer',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getcompositlayerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getcompositlayerData());
          Mage::getSingleton('adminhtml/session')->setcompositlayerData(null);
      } elseif ( Mage::registry('compositlayer_data') ) {
          $form->setValues(Mage::registry('compositlayer_data')->getData());
      }
      return parent::_prepareForm();
  }
}
