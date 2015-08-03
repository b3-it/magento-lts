<?php

class Egovs_Informationservice_Block_Adminhtml_System_Product_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'product_edit_form',
      								  'name' => 'product_edit_form',
                                      'action' => $this->getUrl('*/*/save'),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );
      $this->setForm($form);
      $form->setUseContainer(true);
      $fieldset = $form->addFieldset('parentcustomer_form', array('legend'=>Mage::helper('extcustomer')->__('Master Product')));
     
      
      $fieldset->addField('master_product_id', 'hidden', array(
          'name'      => 'master_product_id',
      ));
      
      
      $fieldset->addField('master_product_name', 'text', array(
          'label'     => Mage::helper('extcustomer')->__('Master Product Name'),
         'disabled' => true,
          'readonly'  => true,
          'name'      => "master_product_name",
      ));


      $id = Mage::getStoreConfig('informationservice/master_product_id', 0);

      if($id)
      {
      	$form->getElement('master_product_id')->setValue($id);
      	$product = Mage::getModel('catalog/product')->load($id);
      	$form->getElement('master_product_name')->setValue($product->getName());
      }
      
      /*
  	  $customer   = Mage::registry('current_customer');
  	  $data = array();
  	  if($customer != null){
  	  
  	  	$parent_id = $customer->getParentCustomerId();
  	  	$form->getElement('parent_customer_id')->setValue($parent_id);
  	  	if($parent_id)
  	  	{
  	  		$customer = Mage::getModel('customer/customer')->load($parent_id);
  	  		$form->getElement('parent_customer_name')->setValue($customer->getName());
  	  	}
  	  }
     */
      return parent::_prepareForm();
  }
  
 
}