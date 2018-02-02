<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Block_Adminhtml_Toll_category_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Block_Adminhtml_Tollcategory_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('toll_category_form', array('legend'=>Mage::helper('bkg_tollpolicy')->__('Toll Category')));

      $fieldset->addField('name', 'text', array(
          'label'     => Mage::helper('bkg_tollpolicy')->__('Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'name',
      ));
      
      $cg = array();
      
      $collection = Mage::getModel('customer/group')->getCollection();
      foreach($collection as $group)
      {
      	$cg[] = array('label' => $group->getCustomerGroupCode(), 'value' => $group->getId());
      }
      
      $collection = Mage::getModel('bkg_tollpolicy/tollcategory_customergroup')->getCollection();
      
      $values = array();
      foreach($collection as $item)
      {
      	$values[] = $item->getCustomerGroupId();
      }
      
      $form->setValues(Mage::registry('toll_category_data')->getData());
      
      $fieldset->addField('customer_group_id', 'multiselect', array(
          'label'     => Mage::helper('bkg_tollpolicy')->__('Customer Group'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'values' => $cg,
          'name'      => 'customer_group_id',
      		'value' => $values
      ));


      return parent::_prepareForm();
  }
}
