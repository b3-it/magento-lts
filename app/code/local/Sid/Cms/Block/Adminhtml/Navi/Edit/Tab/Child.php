<?php
/**
 * Sid Cms
 *
 *
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms_Block_Adminhtml_Navi_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Cms_Block_Adminhtml_Navi_Edit_Tab_Child extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('child_form', array('legend'=>Mage::helper('sidcms')->__('Item information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('sidcms')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      if ( Mage::getSingleton('adminhtml/session')->getCmsData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCmsData());
          Mage::getSingleton('adminhtml/session')->setCmsData(null);
      } elseif ( Mage::registry('navi_data') ) {
          $form->setValues(Mage::registry('navi_data')->getData());
      }
      return parent::_prepareForm();
  }
}
