<?php

class Egovs_Extstock_Block_Adminhtml_Extstock_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Form
{
	private $_product = null;
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('extstock_product', array('legend'=>Mage::helper('extstock')->__('Product')));
     
      
   	  $data = null;
      if ( $data = Mage::getSingleton('adminhtml/session')->getExtstockData() )
      {
          Mage::getSingleton('adminhtml/session')->setExtstockData(null);
      } elseif ( Mage::registry('extstock_data') ) {
      	  $data = Mage::registry('extstock_data')->getData();	     
      }     
      
      //if(in_array('product_id',$data)) 
      if(isset($data['product_id']))
      	$this->getProductById($data['product_id']);
      else
		$this->getProductByRequest();

      
      if($this->_product == null)
      {
	      $fieldset->addField('product_id', 'text', array(
	          'label'     => Mage::helper('extstock')->__('Product ID (erstmal)'),
	          'class'     => 'required-entry',
	          'required'  => true,
	          'name'      => 'product_id',
	      ));
	      
	      $form->setValues($data);
      }
      else
      {  	
      		$fieldset->addField('product_id', 'hidden', array(
	          'required'  => true,
	          'name'      => 'product_id',
      		  'value'		=> $this->_product->getEntityId(),		
	      ));
	      
	       $fieldset->addField('product_name', 'text', array(
	          'label'     => Mage::helper('extstock')->__('Name'),
	       	  'disabled'  => 'disabled',
	          'name'      => 'product_name',
	       	  'value'	  => $this->_product->getData('name'),
	      ));
	      
	      $name = $this->_product->getData('sku');
	      $fieldset->addField('product_sku', 'text', array(
	          'label'     => Mage::helper('extstock')->__('sku'),
	      	  'disabled'  => 'disabled',		
	          'name'      => 'product_sku',
	       	  'value'	  => $this->_product->getData('sku'),
	      ));
      }
     
      //$form->setValues($data);
      
     
      /*
      if ( $data = Mage::getSingleton('adminhtml/session')->getExtstockData() )
      {
          $form->setValues($data);
          Mage::getSingleton('adminhtml/session')->setExtstockData(null);
      } elseif ( Mage::registry('extstock_data') ) {
      	  $data = Mage::registry('extstock_data')->getData();	
          $form->setValues($data);
      }
      */
    
      
      return parent::_prepareForm();
  }
  
   public function getProductByRequest()
    {
        if (is_null($this->_product)) 
        {
        	$req = $this->getRequest()->getParam('productid');
        	if($req != null)
        	{
	            $this->_product = Mage::getModel('catalog/product')
	                ->setStore(0)
	                ->load($req);
        	}
        }
        return $this->_product;
    }
    
  public function getProductById($id)
    {
        if (is_null($this->_product)) {
            $this->_product = Mage::getModel('catalog/product')
                ->setStore(0)
                ->load($id);
        }
        return $this->_product;
    }
}