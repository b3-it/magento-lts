<?php

class Stala_Abo_Block_Adminhtml_Contract_Edit_Form extends Stala_Abo_Block_Adminhtml_Contract_Abstract
{

	
	
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('contract_form', array('legend'=>Mage::helper('stalaabo')->__('Contract Information')));
     
      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
      
      $fieldset->addField('customer_id', 'hidden', array(
          'name'      => 'customer_id',
          'value'    => $this->_getCustomer()->getId(),
      	));
      
      
      $fieldset->addField('from_date', 'date', array(
            'name'   => 'from_date',
            'label'  => Mage::helper('stalaabo')->__('From Date'),
            'title'  => Mage::helper('stalaabo')->__('From Date'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format'       => $dateFormatIso,
      		'disabled'  =>true,
        ));

  
	  
      $fieldset->addField('billing_adr', 'text', array(
          'label'     => Mage::helper('stalaabo')->__('Billing Address'),
          'name'      => 'billing_adr',
          //'values'    => $this->AddressesToHashArray(),
      	  'disabled'  =>true,
      	));
      	
      $fieldset->addField('shipping_adr', 'text', array(
          'label'     => Mage::helper('stalaabo')->__('Shipping Address'),
          'name'      => 'shipping_adr',
          //'values'    => $this->AddressesToHashArray(),
      	  'disabled'  =>true,
      	));
     
       $fieldset->addField('sku', 'text', array(
          'name'      => 'sku',
          'label'     => Mage::helper('stalaabo')->__('Sku'),
       	 'disabled'  =>true,
      	));
      	
      $fieldset->addField('product', 'text', array(
          'name'      => 'product',
          'label'     => Mage::helper('stalaabo')->__('Product'),
       	 'disabled'  =>true,
      	));
  
      	      	
      $fieldset->addField('qty', 'text', array(
          'name'      => 'qty',
          'label'     => Mage::helper('stalaabo')->__('Qty'),
       	 'disabled'  =>true,
      	));
     
      if ( Mage::getSingleton('adminhtml/session')->getAboData() )
      {
          $data = ($this->getProductData(Mage::getSingleton('adminhtml/session')->getAboData()));
          Mage::getSingleton('adminhtml/session')->setAboData(null);
      } elseif ( Mage::registry('contract_data') ) {
          $data=($this->getProductData(Mage::registry('contract_data')->getData()));
      }
 
      $data['billing_adr'] = $this->getAddressById($data['billing_address_id']);
      $data['shipping_adr'] = $this->getAddressById($data['shipping_address_id']);
      
      $form->setValues($data);
      return parent::_prepareForm();
  }
  
  private function getProductData($data)
  {
  	//echo "<pre>"; var_dump($data); die();
  	$product_id = $data['base_product_id'];
  	$product = Mage::getModel('catalog/product')->load($product_id);
  	$data['sku'] = $product->getSku();
  	$data['product'] = $product->getName();
  	
  	return $data;
  }
  
  
  
  private function _getCustomer()
  {
	    if($this->_customer == null)
	    {
	    	$contract = Mage::registry('contract_data')->getData();	
	    	$this->_customer = Mage::getModel('customer/customer')->load($contract['customer_id']);
	    }
	    return $this->_customer;
  }
  
}