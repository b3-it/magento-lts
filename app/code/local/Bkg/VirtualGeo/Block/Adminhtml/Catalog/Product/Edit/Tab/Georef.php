<?php
/**
 * 
 * */
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Georef extends Mage_Adminhtml_Block_Widget
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	
	public function __construct($attributes)
	{
		$this->_attributes = $attributes;
		parent::__construct();
		//$this->setTemplate('bkg/virtualgeo/product/edit/tab/fees.phtml');
		$this->setId('fees');
	
	}
	
    public function getTabLabel()
    {
        return Mage::helper('virtualgeo')->__('Georef');
    }
    public function getTabTitle()
    {
        return Mage::helper('virtualgeo')->__('Georef');
    }
    

    protected function _toHtml()
    {
    	return $this->getChild('georef_form')->toHtml();
    }
    
    protected function _prepareLayout()
    {
    	$this->setChild('georef_form',
    			$this->getLayout()->createBlock('virtualgeo/adminhtml_catalog_product_edit_tab_georef_form')
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
    
    public function getProduct()
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
