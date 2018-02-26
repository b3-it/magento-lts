<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Test_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);
      
      $fieldset = $form->addFieldset('entity_form', array('legend'=>Mage::helper('bkg_license')->__('General')));
      
      $collection = Mage::getModel('customer/customer')->getCollection();
      $values = array();
      
      foreach($collection as $item)
      {
      	$values[] = array('label'=>$item->getEmail(),'value'=>$item->getId());
      }
      
      
      $fieldset->addField('customer', 'select', array(
      		'label'     => Mage::helper('bkg_license')->__('Customer'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'customer',
      		'values' => $values
      ));

      $fieldset->addField('type', 'select', array(
          'label'     => Mage::helper('bkg_license')->__('Type of License'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'type',
          'values' => Bkg_License_Model_Type::getOptionArray(),

      ));
      
      
      $collection = Mage::getModel('catalog/product')->getCollection();
      $values = array();
      
      foreach($collection as $item)
      {
      	$values[] = array('label'=>$item->getSku(),'value'=>$item->getId());
      }
      
      
      $fieldset->addField('product', 'select', array(
      		'label'     => Mage::helper('bkg_license')->__('Product'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'product',
      		'values' => $values
      ));
      
      $fieldset = $form->addFieldset('entity_form1', array('legend'=>Mage::helper('bkg_license')->__('Toll')));
 
      $collection = Mage::getModel('bkg_tollpolicy/useoptions')->getCollection();
      $values = array();
      
      foreach($collection as $item)
      {
      	$values[] = array('label'=>$item->getId()." : ".$item->getName(),'value'=>$item->getId());
      }
      
      $collection = Mage::getModel('bkg_tollpolicy/tollcategory')->getCollection();
      $categorys = array();
      $categorys[] = array('value'=>0,'label'=>$this->__('-- Please Select --'));
      foreach ($collection as $item)
      {
      	$categorys[] = array('value'=>$item->getId(),'label'=>$item->getName());
      }
      
      $fieldset->addField('tollcategory', 'select', array(
      		'label'     => Mage::helper('bkg_license')->__('Category'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'tollcategory',
      		'values' => $categorys,
      		'onchange'  => 'reloadToll()',
      ));
      
      $fieldset->addField('toll', 'select', array(
      		'label'     => Mage::helper('bkg_license')->__('Toll'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'toll',
      		//'values' => $categorys,
      		'onchange'  => 'reloadUse()',
      ));
      
      
      $fieldset->addField('tolluse', 'select', array(
      		'label'     => Mage::helper('bkg_license')->__('Type of Use'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'tolluse',
      		//'values' => $categorys,
      		'onchange'  => 'reloadUseOpt()',
      ));
      
      $fieldset->addField('tolloption', 'select', array(
      		'label'     => Mage::helper('bkg_license')->__('useoption'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'tolloption',
      		'values' => $values
      ));
      
      return parent::_prepareForm();
  }
}
