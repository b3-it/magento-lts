<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journal_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Journal_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('kassenbuchjournal_form', array('legend'=>Mage::helper('gka_barkasse')->__(' Kassenbuch Journal information')));

      $model = $this->_getKassenbuchjournal();
      $isNew = ($model == null) || ($model->getId() == 0);
      
      
      
     
      if(!$isNew)
      {
      	
      	$fieldset->addField('number', 'text', array(
      			'label'     => Mage::helper('gka_barkasse')->__('Number'),
      			//'class'     => 'required-entry',
      			//'required'  => true,
      			'disabled'	=> true,
      			'name'      => 'number',
      			'value' 	=> $model->getNumber(),
      		));
	      $fieldset->addField('owner', 'text', array(
	          'label'     => Mage::helper('gka_barkasse')->__('Owner'),
	          //'class'     => 'required-entry',
	          //'required'  => true,
	      	  'disabled'	=> true,
	          'name'      => 'owner',
	      	  'value' 	=> $model->getOwner(),	
	      ));
	      
	      $fieldset->addField('cashbox_title', 'text', array(
	      		'label'     => Mage::helper('gka_barkasse')->__('Cashbox'),
	      		//'class'     => 'required-entry',
	      		//'required'  => true,
	      		'name'      => 'cashbox_title',
	      		'disabled'	=> true,
	      		'value' 	=> $model->getCashboxTitle(),
	      ));
	      
	      $fieldset->addField('opening', 'text', array(
	      		'label'     => Mage::helper('gka_barkasse')->__('Opening'),
	      		//'class'     => 'required-entry',
	      		//'required'  => true,
	      		'name'      => 'opening',
	      		'disabled'	=> true,
	      		'value' 	=> $model->getFormatedOpeningDateTime(),
	      ));
	      if($model->getStatus() == Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED)
	      {
		      $fieldset->addField('closing', 'text', array(
		      		'label'     => Mage::helper('gka_barkasse')->__('Closing'),
		      		//'class'     => 'required-entry',
		      		//'required'  => true,
		      		'name'      => 'closing',
		      		'disabled'	=> true,
		      		'value' 	=> $model->getFormatedClosingDateTime(),
		      ));
	      }
	      
	      $fieldset->addField('opening_balance', 'text', array(
	      		'label'     => Mage::helper('gka_barkasse')->__('Opening Balance'),
	      		//'class'     => 'required-entry',
	      		//'required'  => true,
	      		'name'      => 'opening_balance',
	      		'disabled'	=> true,
	      		'value' 	=> $model->getOpeningBalance(),
	      ));
	      $fieldset->addField('closing_balance', 'text', array(
	      		'label'     => Mage::helper('gka_barkasse')->__('Closing Balance'),
	      		//'class'     => 'required-entry',
	      		//'required'  => true,
	      		'name'      => 'closing_balance',
	      		'disabled'	=> $model->getStatus() == Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED,
	      		'value' 	=> $model->getClosingBalance(),
	      ));
	       
	      $fieldset->addField('status', 'select', array(
	      		'label'     => Mage::helper('gka_barkasse')->__('Status'),
	      		//'class'     => 'required-entry',
	      		//'required'  => true,
	      		'name'      => 'status',
	      		'values'    => Gka_Barkasse_Model_Kassenbuch_Journal_Status::getAllOptions(false),
	      		'disabled'	=> $model->getStatus() == Gka_Barkasse_Model_Kassenbuch_Journal_Status::STATUS_CLOSED,
	      		'value' 	=> $model->getStatus(),
	      ));
	       
      }else{
	       $fieldset->addField('customer_id', 'select', array(
      		'label'     => Mage::helper('gka_barkasse')->__('User'),
      		'class'     => 'required-entry',
	      	'required'  => true,
	      	'name'      => 'customer_id',
	      	'values'    => $this->__getCustomerList()
      		));
      
	      $fieldset->addField('cashbox_id', 'select', array(
	      		'label'     => Mage::helper('gka_barkasse')->__('Cashbox'),
	      		'class'     => 'required-entry',
	      		'required'  => true,
	      		'name'      => 'cashbox_id',
	      		//'disabled'	=> true,
	      		'values'    => $this->__getCashboxList()
	      ));
	      
	      $fieldset->addField('opening_balance', 'text', array(
	      		'label'     => Mage::helper('gka_barkasse')->__('Opening Balance'),
	      		//'class'     => 'required-entry',
	      		//'required'  => true,
	      		'name'      => 'opening_balance',
	      		//'disabled'	=> true,
	      ));
	     
      }
      

      return parent::_prepareForm();
  }
  
  protected function _getKassenbuchjournal()
  {
  	$res = null;
	  	if ( Mage::getSingleton('adminhtml/session')->getkassenbuchjournalData() )
	  	{
	  		$res = Mage::getSingleton('adminhtml/session')->getkassenbuchjournalData();
	  		
	  	} elseif ( Mage::registry('kassenbuchjournal_data') ) {
	  		$res = Mage::registry('kassenbuchjournal_data');
	  	}
	  	
	  	return $res;
  }
  
  private function __getCustomerList()
  {
  	$collection = Mage::getResourceModel('customer/customer_collection')
  	->addNameToSelect()
  	->addAttributeToSelect('email')
  	//->joinField('store_name', 'core/store', 'name', 'store_id=store_id', null, 'left')
  	;
  	 
  
  	$res = array();
  	$res[0] = Mage::helper('gka_barkasse')->__('-- Please Select --');
  	foreach($collection->getItems() as $item)
  	{
  		$res[$item->getEntityId()] = $item->getName();
  	}
  
  	return $res;
  }
  
  private function __getCashboxList()
  {
  	$collection = Mage::getResourceModel('gka_barkasse/kassenbuch_cashbox_collection');

  	$res = array();
  	$res[0] = Mage::helper('gka_barkasse')->__('-- Please Select --');
  	foreach($collection->getItems() as $item)
  	{
  		$res[$item->getId()] = $item->getTitle();
  	}
  
  	return $res;
  }
  
}
