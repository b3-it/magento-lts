<?php
/**
 *
 * @category   	Egovs ContextHelp
 * @package    	Egovs_ContextHelp
 * @name       	Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('contexthelp_form', array('legend'=>Mage::helper('contexthelp')->__(' Contexthelp information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('contexthelp')->__('Title'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'title',
      ));
      


      $opt= Mage::getModel('contexthelp/category')->getOptions();     	
      
      $fieldset->addField('category_id', 'select', array(
          'label'     => Mage::helper('contexthelp')->__('Category'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'category_id',
      		'options' => $opt,
      ));
    

      
      $model = Mage::registry('contexthelp_data');

      $value = array();
      foreach($model->getHandles() as $item)
      {
      	$value[] = array('value'=>$item->getHandle());
      }
      
      $values = $this->_getHandles();
      $fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
      $fieldset->addField('handle', 'ol', array(
      		'label'     => Mage::helper('contexthelp')->__('Handler'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'show_up_down' =>false,
      		'name'      => 'handle',
      		'values' =>$values,
      		'value' => $value
      ));
      
      
      $value = array();
      foreach($model->getBlocks() as $item)
      {
      	$value[] = array('value'=>$item->getBlockId(),'pos'=>$item->getPos());
      }
      
      $values = $this->_getCmsBlocks();
      $fieldset->addType('ol','Egovs_Base_Block_Adminhtml_Widget_Form_Ol');
      $fieldset->addField('block', 'ol', array(
      		'label'     => Mage::helper('contexthelp')->__('Block'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'block',
      		'values' =>$values,
      		'value' => $value
      ));
      
     
/*

      if ( Mage::getSingleton('adminhtml/session')->getcontexthelpData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getcontexthelpData());
          Mage::getSingleton('adminhtml/session')->setcontexthelpData(null);
      } elseif ( Mage::registry('contexthelp_data') ) {
          $form->setValues(Mage::registry('contexthelp_data')->getData());
      }
      */
      return parent::_prepareForm();
  }
  
  
  protected function _getCmsBlocks()
  {
  	$collection = Mage::getModel('cms/block')->getCollection();
  	$res = array();
  
  
  	foreach($collection as $item)
  	{
  		$res[$item->getIdentifier()] = array('label'=>$item->getTitle(), 'value'=>$item->getId());
  	}
  	return $res;
  }
  
  protected function _getHandles()
  {
  	$collection = Mage::getModel('cms/block')->getCollection();
  	$res = array();
  
  
  	foreach($collection as $item)
  	{
  		$res[$item->getIdentifier()] = array('label'=>$item->getTitle(), 'value'=>$item->getIdentifier());
  	}
  	return $res;
  }
  
}
