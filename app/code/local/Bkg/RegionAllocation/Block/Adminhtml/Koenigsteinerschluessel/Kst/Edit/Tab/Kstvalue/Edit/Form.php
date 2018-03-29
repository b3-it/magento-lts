<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name       	Bkg_Regionallocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit_Tab_Kstvalue_Edit_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_RegionAllocation_Block_Adminhtml_Koenigsteinerschluessel_Kst_Edit_Tab_Kstvalue_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      
      
      $form = new Varien_Data_Form(array(
      		'id' => 'edit_form',
      		'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
      		'method' => 'post',
      		'enctype' => 'multipart/form-data'
      )
      		);
      
      $form->setUseContainer(true);
      
      $this->setForm($form);
      $fieldset = $form->addFieldset('koenigsteinerschluesselkst_value_form', array('legend'=>Mage::helper('regionallocation')->__(' Koenigsteinerschluessel Kstvalue information')));

      $fieldset->addField('kst_id', 'hidden', array(
          'label'     => Mage::helper('regionallocation')->__('Parent Id'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'kst_id'
      ));
      $fieldset->addField('region', 'text', array(
          'label'     => Mage::helper('regionallocation')->__('Region'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'region',
      ));
      
      $fieldset->addField('has_tax', 'select', array(
          'label'     => Mage::helper('regionallocation')->__('Has Tax'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'has_tax',
      	  'values'    => Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
      ));
      
      $fieldset->addField('portion', 'text', array(
          'label'     => Mage::helper('regionallocation')->__('Portion'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'portion',
      ));



      if ( Mage::getSingleton('adminhtml/session')->getkoenigsteinerschluesselkst_valueData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getkoenigsteinerschluesselkst_valueData());
          Mage::getSingleton('adminhtml/session')->setkoenigsteinerschluesselkst_valueData(null);
      } elseif ( Mage::registry('koenigsteinerschluesselkst_value_data') ) {
          $form->setValues(Mage::registry('koenigsteinerschluesselkst_value_data')->getData());
      } 
      return parent::_prepareForm();
  }
}
