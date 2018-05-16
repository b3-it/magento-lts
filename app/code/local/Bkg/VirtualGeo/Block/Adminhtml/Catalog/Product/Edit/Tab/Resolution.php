<?php
/**
 * 
 * */
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Resolution extends Mage_Adminhtml_Block_Widget
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	
	public function __construct($attributes)
	{
		$this->_attributes = $attributes;
		parent::__construct();
		$this->setId('resolution');
	
	}
	
    public function getTabLabel()
    {
        return Mage::helper('virtualgeo')->__('Resolution');
    }
    public function getTabTitle()
    {
        return Mage::helper('virtualgeo')->__('Resolution');
    }
    
    protected function _toHtml()
    {
    	return $this->getChild('resolution_form')->toHtml();
    }
    
 	protected function _prepareLayout()
    {
    	$this->setChild('resolution_form',
    			$this->getLayout()->createBlock('virtualgeo/adminhtml_catalog_product_edit_tab_resolution_form')
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
