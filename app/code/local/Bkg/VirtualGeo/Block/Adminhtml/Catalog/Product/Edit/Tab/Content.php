<?php
/**
 * 
 * */
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Content extends Mage_Adminhtml_Block_Widget
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
 
	
	public function __construct($attributes)
	{
		$this->_attributes = $attributes;
		parent::__construct();
		$this->setTemplate('bkg/virtualgeo/product/edit/tab/content.phtml');
		$this->setId('virtualgeo_content');
	
	}
	
    public function getTabLabel()
    {
        return Mage::helper('virtualgeo')->__('Content');
    }
    public function getTabTitle()
    {
        return Mage::helper('virtualgeo')->__('Content');
    }
    

    
    protected function _prepareLayout()
    {
    	
    	
    	$this->setChild('content_layer',
    			$this->getLayout()->createBlock('virtualgeo/adminhtml_catalog_product_edit_tab_content_layer',
    					'adminhtml.catalog.product.edit.tab.content.layer')
    			);
    	

    	
    	$this->setChild('content_form',
    			$this->getLayout()->createBlock('virtualgeo/adminhtml_catalog_product_edit_tab_content_form',
    					'adminhtml.catalog.product.edit.tab.content.form')
    			);

    	return Mage_Adminhtml_Block_Widget::_prepareLayout();
    }
   
    public function canShowTab()
    {
    	return true;
    }
    public function isHidden()
    {
    	return false;
    }
    
    public function getLayerHtml()
    {
    	return $this->getChildHtml('content_layer');
    }
    
    public function getFormHtml()
    {
    	return $this->getChildHtml('content_form');
    }
    
    public function getSelectiontoolsHtml()
    {
    	return $this->getChildHtml('content_tools');
    }
    
    
    public function getAddButtonHtml()
    {
    	return $this->getChildHtml('add_button');
    }
    
    
    private function getProductId()
    {
    	if($this->getData('product_id')!= null)
    	{
    		return $this->getData('product_id');
    	}
    
    	$product = Mage::registry('product');
    	if($product)
    	{
    		return $product->getId();
    	}
    	return 0;
    }
    
    private function getProduct()
    {
    	
    	$product = Mage::registry('product');
    	if($product)
    	{
    		return $product();
    	}
    	return null;
    }
    
    public function getFieldValue($field)
    {
    	$product = Mage::registry('product');
    	if($product)
    	{
    		return $product->getData($field);
    	}
    	return null;
    }
    
}
