<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Account_Edit_Tab_Form
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Account_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
  	
  	$debug = (bool) Mage::getStoreConfigFlag('dwd_icd/debug/is_debug');  	
  	if ($debug) { 
  		return $this->_prepareFormDebug();
  	}
  	
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('account_form', array('legend'=>Mage::helper('dwd_icd')->__('Item information')));
     
      $fieldset->addField('customer_id', 'text', array(
      		'label'     => Mage::helper('dwd_icd')->__('Customer Id'),
      		'readonly'  => true,
      		'name'      => 'customer_id',
      ));
      
      $fieldset->addField('login', 'text', array(
          'label'     => Mage::helper('dwd_icd')->__('Login Name'),
          'readonly'  => true,
          'name'      => 'login',
      ));
      
      $fieldset->addField('password', 'text', array(
      		'label'     => Mage::helper('dwd_icd')->__('Password'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'password',
      ));
      
     
      
      
      $options = array();
      foreach(Mage::getModel('dwd_icd/connection')->getCollection()->getItems() as $item)
      {
      	$options[] = array('label' => $item->getTitle(), 'value' => $item->getId());
      }
      
      $fieldset->addField('connection_id', 'select', array(
      		'label'     => Mage::helper('dwd_icd')->__('Connection'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'connection_id',
      		'values'	=> $options
      		
            ));
  
      
		
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('dwd_icd')->__('Status'),
          'name'      => 'status',
          'values'    => Dwd_Icd_Model_AccountStatus::getOptionArray()
      ));
      
      $fieldset->addField('sync_status', 'select', array(
      		'label'     => Mage::helper('dwd_icd')->__('Synchronization'),
      		'name'      => 'sync_status',
      		'values'    => Dwd_Icd_Model_Syncstatus::getOptionArray()
      ));
     
      $fieldset->addField('error', 'text', array(
      		'label'     => Mage::helper('dwd_icd')->__('Message'),
      		'class'     => 'read-only',
      		'name'      => 'error',
      ));

     
      if ( Mage::getSingleton('adminhtml/session')->getIcdData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getIcdData());
          Mage::getSingleton('adminhtml/session')->setIcdData(null);
      } elseif ( Mage::registry('account_data') ) {
          $form->setValues(Mage::registry('account_data')->getData());
      }
      return parent::_prepareForm();
  }
  
  protected function _prepareFormDebug()
  {
  	 
  	
  	$form = new Varien_Data_Form();
  	$this->setForm($form);
  	$fieldset = $form->addFieldset('account_form', array('legend'=>Mage::helper('dwd_icd')->__('Item information')));
  	 
  	$fieldset->addField('semaphor', 'text', array(
  			'label'     => Mage::helper('dwd_icd')->__('Semaphor'),
  			'class'     => 'required-entry',
  			'required'  => true,
  			'name'      => 'semaphor',
  			'note'		=> '0 or 1'
  	));
  	 
  	
  	
  	$fieldset->addField('customer_id', 'text', array(
  			'label'     => Mage::helper('dwd_icd')->__('Customer Id'),
  			'class'     => 'required-entry',
  			'required'  => true,
  			'name'      => 'customer_id',
  	));
  	
  	
  	$fieldset->addField('login', 'text', array(
  			'label'     => Mage::helper('dwd_icd')->__('Login Name'),
  			'class'     => 'required-entry',
  			'required'  => true,
  			'name'      => 'login',
  	));
  
  	$fieldset->addField('password', 'text', array(
  			'label'     => Mage::helper('dwd_icd')->__('Password'),
  			//'class'     => 'required-entry',
  			//'required'  => true,
  			'name'      => 'password',
  	));
  
  
  
  
  	$options = array();
  	foreach(Mage::getModel('dwd_icd/connection')->getCollection()->getItems() as $item)
  	{
  		$options[] = array('label' => $item->getTitle(), 'value' => $item->getId());
  	}
  
  	$fieldset->addField('connection_id', 'select', array(
  			'label'     => Mage::helper('dwd_icd')->__('Connection Id'),
  			'class'     => 'required-entry',
  			'required'  => true,
  			'name'      => 'connection_id',
  			'values'	=> $options
  
  	));
  
  
  
  	$fieldset->addField('status', 'select', array(
  			'label'     => Mage::helper('dwd_icd')->__('Status'),
  			'name'      => 'status',
  			'values'    => Dwd_Icd_Model_AccountStatus::getOptionArray()
  	));
  
  	$fieldset->addField('sync_status', 'select', array(
  			'label'     => Mage::helper('dwd_icd')->__('Synchronization'),
  			'name'      => 'sync_status',
  			'values'    => Dwd_Icd_Model_Syncstatus::getOptionArray()
  	));
  	 
  	$fieldset->addField('error', 'text', array(
  			'label'     => Mage::helper('dwd_icd')->__('Message'),
  			'class'     => 'read-only',
  			'name'      => 'error',
  	));
  
  	 
  	if ( Mage::getSingleton('adminhtml/session')->getIcdData() )
  	{
  		$form->setValues(Mage::getSingleton('adminhtml/session')->getIcdData());
  		Mage::getSingleton('adminhtml/session')->setIcdData(null);
  	} elseif ( Mage::registry('account_data') ) {
  		$form->setValues(Mage::registry('account_data')->getData());
  	}
  	return parent::_prepareForm();
  }
  
  
  
  
  
}