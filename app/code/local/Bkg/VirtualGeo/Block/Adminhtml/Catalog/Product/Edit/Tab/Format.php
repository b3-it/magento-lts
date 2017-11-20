<?php
/**
 * 
 * */
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Format extends Mage_Adminhtml_Block_Widget
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
        return Mage::helper('virtualgeo')->__('Format');
    }
    public function getTabTitle()
    {
        return Mage::helper('virtualgeo')->__('Format');
    }
    
    protected function _toHtml()
    {
    	return $this->getChild('format_form')->toHtml();
    }
    
 	protected function _prepareLayout()
    {
    	$this->setChild('format_form',
    			$this->getLayout()->createBlock('virtualgeo/adminhtml_catalog_product_edit_tab_format_form')
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
    
 
    
   
}
