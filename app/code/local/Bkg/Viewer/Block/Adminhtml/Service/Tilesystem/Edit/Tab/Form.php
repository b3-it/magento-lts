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
class Bkg_Viewer_Block_Adminhtml_Service_Tilesystem_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('serviceservice_form', array('legend'=>Mage::helper('bkgviewer')->__('Tile information')));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'name',
      ));
      
      $fieldset->addField('ident', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('Ident'),
          //'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'ident',
      ));
      
      $fieldset->addField('crs', 'text', array(
          'label'     => Mage::helper('bkgviewer')->__('CRS'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'crs',
      ));
      




      if ( Mage::getSingleton('adminhtml/session')->getTilesystemData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTilesystemData());
          Mage::getSingleton('adminhtml/session')->setTilesystemData(null);
      } elseif ( Mage::registry('tilesystem_data') ) {
          $form->setValues(Mage::registry('tilesystem_data')->getData());
      }
      return parent::_prepareForm();
  }
}
