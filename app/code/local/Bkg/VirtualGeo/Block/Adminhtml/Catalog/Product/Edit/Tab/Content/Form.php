<?php
/**
 * 
 * @author h.koegel
 *
 */

class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Content_Form extends Mage_Adminhtml_Block_Widget_Form
{
    public function x__construct()
    {
        parent::__construct();
        $this->setTemplate('bkg/virtualgeo/product/edit/tab/content/form.phtml');
       
    }

    
	protected function _prepareForm()
    	{
    		$form = new Varien_Data_Form();
    		$this->setForm($form);
    		$fieldset = $form->addFieldset('compositlayer_form', array('legend'=>Mage::helper('bkgviewer')->__('Item information')));
    
    		$fieldset->addField('code', 'text', array(
    				'label'     => Mage::helper('virtualgeo')->__('Code'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'title',
    		));
    		
    		$fieldset->addField('name', 'text', array(
    				'label'     => Mage::helper('virtualgeo')->__('Name'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'Name',
    		));
    		
    		$fieldset->addField('is_checked', 'checkbox', array(
    				'label'     => Mage::helper('virtualgeo')->__('Is Checked'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'is_checked',
    		));
    		
    		$fieldset->addField('is_readonly', 'checkbox', array(
    				'label'     => Mage::helper('virtualgeo')->__('Is Readonly'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'is_readonly',
    		));
    		
    		$fieldset->addField('toogle_all', 'checkbox', array(
    				'label'     => Mage::helper('virtualgeo')->__('Toogle All'),
    				//'class'     => 'required-entry',
    				//'required'  => true,
    				'name'      => 'toogle_all',
    		));
    		
    		
    
    		$fieldset->addField ( 'copy_values', 'button', array (
    				'value' => Mage::helper ( 'virtualgeo' )->__ ( 'Insert' ),
    				'name' => 'copy_values',
    				'onclick' => "addPages();",
    				'class'	=> 'form-button',
    				'label' => Mage::helper ( 'virtualgeo' )->__ ( 'Copy selected Layer to Tree' ),
    		) );
    
    		if ( Mage::getSingleton('adminhtml/session')->getcompositlayerData() )
    		{
    			$form->setValues(Mage::getSingleton('adminhtml/session')->getcompositlayerData());
    			Mage::getSingleton('adminhtml/session')->setcompositlayerData(null);
    		} elseif ( Mage::registry('compositlayer_data') ) {
    			$form->setValues(Mage::registry('compositlayer_data')->getData());
    		}
    		return parent::_prepareForm();
    	}
    
    
    
    
    //alle verfügbaren PersonalOptions für das Produkt finden 
	public function getFields()
	{
	
		return array();
	}

	private function getStoreId()
	{
		$storeId  = $this->getRequest()->getParam('store');
		return intval($storeId);
		
	}
	
	
	
	
	private function getProduct()
	{
		$product = Mage::registry('product');
		if($product)
		{
			return $product;
		}
		
		if($this->getData('product_id')!= null)
		{
			$product = Mage::getModel('catalog/product')->load('product_id');
			$product->setStoreId($this->getStoreId());
			return $product;
		}
	
		
		return null;
	}
	
	public function getFieldsAvail()
	{
		$fields = array();//Mage::getConfig()->getNode('global/eventbundle_personal/fields')->asArray();
		return $fields;
	}
	
}
