<?php
/**
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name       	Dwd_Ibewi_Block_Adminhtml_Kostentraeger_Attribute_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Block_Adminhtml_Kostentraeger_Attribute_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('kostentraegerattribute_form', array('legend'=>Mage::helper('ibewi')->__('Attribute information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('ibewi')->__('Title'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'title',
      ));
      $fieldset->addField('value', 'text', array(
          'label'     => Mage::helper('ibewi')->__('Cost Unit'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'value',
      ));
      
      $fieldset->addField('pos', 'text', array(
      		'label'     => Mage::helper('ibewi')->__('Position'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'pos',
      ));
    
//       $fieldset->addField('standard', 'select', array(
//       		'label'     => Mage::helper('ibewi')->__('Standard'),
//       		'name'      => 'standard',
//       		'values'    => Dwd_Ibewi_Model_Kostentraeger_Yesno::getOptionArray()
//       ));
      



      if ( Mage::getSingleton('adminhtml/session')->getkostentraegerattributeData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getkostentraegerattributeData());
          Mage::getSingleton('adminhtml/session')->setkostentraegerattributeData(null);
      } elseif ( Mage::registry('kostentraegerattribute_data') ) {
          $form->setValues(Mage::registry('kostentraegerattribute_data')->getData());
      }
      return parent::_prepareForm();
  }
}
