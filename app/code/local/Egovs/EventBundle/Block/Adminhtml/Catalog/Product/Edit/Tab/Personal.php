<?php
/**
 * 
 * */
class Egovs_EventBundle_Block_Adminhtml_Catalog_Product_Edit_Tab_Personal extends Mage_Adminhtml_Block_Widget
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
 
	
	public function __construct($attributes)
	{
		$this->_attributes = $attributes;
		parent::__construct();
		$this->setTemplate('egovs/eventbundle/product/edit/tab/personal.phtml');
		$this->setId('personal_settings');
	
	}
	
    public function getTabLabel()
    {
        return Mage::helper('eventbundle')->__('Personalization');
    }
    public function getTabTitle()
    {
        return Mage::helper('eventbundle')->__('Personalization');
    }
    

    
    protected function _prepareLayout()
    {
    	$this->setChild('add_button',
    			$this->getLayout()->createBlock('adminhtml/widget_button')
    			->setData(array(
    					'label' => Mage::helper('bundle')->__('Add New Option'),
    					'class' => 'add',
    					'id'    => 'add_new_option',
    					'on_click' => 'personalOption.add(null)'
    			))
    	);
    	
    	
    	
    	
    	 $this->setChild('personal_field_box',
    	 $this->getLayout()->createBlock('eventbundle/adminhtml_catalog_product_edit_tab_personal_fields',
    	 'adminhtml.catalog.product.edit.tab.bundle.fields')
    	 );
    	 
    	 
    	
    	return Mage_Adminhtml_Block_Widget::_prepareLayout();
    }
   
    public function canShowTab()
    {
    	$show =  Mage::getConfig()->getNode('global/eventbundle_personal/show')->asArray();
    	if($show === 'true'){
    		return boolval($this->getProductId() > 0);
    	}
    	
    	return false;
    }
    public function isHidden()
    {
    	return false;
    }
    
    public function getFieldsHtml()
    {
    	return $this->getChildHtml('personal_field_box');
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
