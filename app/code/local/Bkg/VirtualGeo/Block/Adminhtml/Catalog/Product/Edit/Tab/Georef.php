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
		$this->setId('georef');
	
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
    
    
 
    

    
   
}
