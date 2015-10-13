<?php

class Stala_Extcustomer_Block_Adminhtml_Customer_Tabs_Parentcustomer_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('parentcustomer_form', array('legend'=>Mage::helper('extcustomer')->__('Parent Customer')));
     
      /*
      $fieldset->addField('parent_customer_id', 'hidden', array(
          'name'      => 'account[parent_customer_id]',
      ));
      */
      $fieldset->addField('parent_customer_id2', 'text', array(
          'name'      => 'account[parent_customer_id2]',
          'label'     => Mage::helper('extcustomer')->__('Parent Customer ID'),
          'disabled' => false,
          'readonly'  => true,
      ));
      
      $fieldset->addField('parent_customer_name', 'text', array(
          'label'     => Mage::helper('extcustomer')->__('Parent Customer Name'),
          'disabled' => false,
          'readonly'  => true,
          'name'      => "parent_customer_name",
      ));


  	  $customer   = Mage::registry('current_customer');
  	  $data = array();
  	  if($customer != null){
  	  
  	  	$parent_id = $customer->getParentCustomerId();
  	  	//$form->getElement('parent_customer_id')->setValue($parent_id);
  	  	$form->getElement('parent_customer_id2')->setValue($parent_id);
  	  	if($parent_id)
  	  	{
  
  	  		
  	  		if($customer->getCustomerOrdersCount()!= 0)
  	  		{
  	  			$fieldset->addField('label1', 'label', array(
		          'label'     => Mage::helper('extcustomer')->__('You can not change customer having some orders!'),
		        
		      ));
  	  		}
  	  		
  	  		$pcustomer = Mage::getModel('customer/customer')->load($parent_id);
  	  		//falls es den Hauptkunden gibt
  	  		if(($pcustomer != null) && ($pcustomer->getId()))
  	  		{
	  	  		$titel = $pcustomer->getCompany();
	  	  		if(strlen(trim($titel))< 1)
	  	  		{
	  	  			$titel = $pcustomer->getName();
	  	  		}
	  	  		$form->getElement('parent_customer_name')->setValue($titel);
  	  		}
  	  		//ansonsten löschen
  	  		else 
  	  		{
  	  			$customer->setParentCustomerId(null)->save();
  	  			$form->getElement('parent_customer_id2')->setValue();
  	  			$fieldset->addField('parent_customer_copy_address', 'checkbox', array(
	          		'label'     => Mage::helper('extcustomer')->__('Copy Parent Address'),
	           		'name'      => "account[parent_customer_copy_address]",
	      			));
  	  		}
  	  	}
  	  	else 
  	   	{
  	  	 	$fieldset->addField('parent_customer_copy_address', 'checkbox', array(
          		'label'     => Mage::helper('extcustomer')->__('Copy Parent Address'),
           		'name'      => "account[parent_customer_copy_address]",
      			));
  	  	}
  	  	
  	  	
  	  }
  	 
  	 
     
      return parent::_prepareForm();
  }
}