<?php
/**
 *
 * @category   	B3it Ids
 * @package    	B3it_Ids
 * @name       	B3it_Ids_Block_Adminhtml_Dos_Url_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Ids_Block_Adminhtml_Dos_Url_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('dosurl_form', array('legend'=>Mage::helper('b3it_ids')->__(' Dos Url information')));

      $fieldset->addField('url', 'text', array(
          'label'     => Mage::helper('b3it_ids')->__('Url'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'url',
      ));
      $fieldset->addField('delay', 'text', array(
          'label'     => Mage::helper('b3it_ids')->__('Delay'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'delay',
      ));
      $fieldset->addField('action', 'select', array(
          'label'     => Mage::helper('b3it_ids')->__('Action'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'action',
          'values' => B3it_Ids_Model_Dos_Action::getOptionArray()
      ));



      if ( Mage::getSingleton('adminhtml/session')->getdosurlData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getdosurlData());
          Mage::getSingleton('adminhtml/session')->setdosurlData(null);
      } elseif ( Mage::registry('dosurl_data') ) {
          $form->setValues(Mage::registry('dosurl_data')->getData());
      }
      return parent::_prepareForm();
  }
}
