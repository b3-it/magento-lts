<?php
/**
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Accounting
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * */
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Accounting extends Mage_Adminhtml_Block_Widget
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	
	public function __construct($attributes)
	{
		$this->_attributes = $attributes;
		parent::__construct();
		$this->setId('accounting');
	
	}
	
    public function getTabLabel()
    {
        return Mage::helper('virtualgeo')->__('Accounting');
    }
    public function getTabTitle()
    {
        return Mage::helper('virtualgeo')->__('Accounting');
    }
    

    protected function _toHtml()
    {
    	return $this->getChild('accounting_form')->toHtml();
    }
    
    protected function _prepareLayout()
    {
    	$this->setChild('accounting_form',
    			$this->getLayout()->createBlock('virtualgeo/adminhtml_catalog_product_edit_tab_accounting_form')
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
