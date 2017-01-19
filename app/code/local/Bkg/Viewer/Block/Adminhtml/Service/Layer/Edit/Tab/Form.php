<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_Adminhtml_Service_Layer_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Service_Layer_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('servicelayer_form', array('legend'=>Mage::helper('bkgviewer')->__('Item information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Title'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'title',
      ));
      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'name',
      ));
      $fieldset->addField('abstract', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Abstract'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'abstract',
      ));
      $fieldset->addField('crs', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Georeference'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'crs',
      ));
      $fieldset->addField('bb_west', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Bounding Box West'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'bb_west',
      ));
      $fieldset->addField('bb_east', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Bounding Box East'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'bb_east',
      ));
      $fieldset->addField('bb_south', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Bounding Box South'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'bb_south',
      ));
      $fieldset->addField('bb_north', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Bounding Box North'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'bb_north',
      ));
      $fieldset->addField('style', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Style'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'style',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getservicelayerData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getservicelayerData());
          Mage::getSingleton('adminhtml/session')->setservicelayerData(null);
      } elseif ( Mage::registry('servicelayer_data') ) {
          $form->setValues(Mage::registry('servicelayer_data')->getData());
      }
      return parent::_prepareForm();
  }
}
