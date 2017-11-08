<?php
/**
 * 
 * */
class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Fees extends Mage_Adminhtml_Block_Widget
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
	
	protected $_RapProcuctCollection = null;
	protected $_RapRelationCollection = null;
 
	public function __construct($attributes)
	{
		$this->_attributes = $attributes;
		parent::__construct();
		$this->setTemplate('bkg/virtualgeo/product/edit/tab/fees.phtml');
		$this->setId('fees');
	
	}
	
    public function getTabLabel()
    {
        return Mage::helper('virtualgeo')->__('Fees');
    }
    public function getTabTitle()
    {
        return Mage::helper('virtualgeo')->__('Fees');
    }
    
    public function getRapProductCollection()
    {
    	if($this->_RapProcuctCollection == null)
    	{
    		$collection = Mage::getModel('catalog/product')->getCollection();
    		$collection->addAttributeToFilter('type_id',array('eq'=>Bkg_RegionAllocation_Model_Product_Type_Regionallocation::TYPE_CODE));
    		$collection->addAttributeToSelect('name');
    		
    		$this->_RapProcuctCollection = $collection->getItems();
    	}
    	
    	return $this->_RapProcuctCollection;
    }
    
    public function getRapRelationCollection()
    {
    	if($this->_RapRelationCollection == null)
    	{
    		$collection = Mage::getModel('virtualgeo/components_regionallocation')->getCollection();
    		$collection->getSelect()
    		->where('parent_id = '.intval($this->getProductId()));
    
    		$this->_RapRelationCollection = $collection->getItems();
    	}
    	 
    	return $this->_RapRelationCollection;
    }

    public function getFeesSections()
    {
    	$sect = Mage::getConfig()->getNode('virtualgeo/fees/sections')->asArray();
    	return $sect;
    }
    
    public function getUsageSections()
    {
    	$sect = Mage::getConfig()->getNode('virtualgeo/usage/sections')->asArray();
    	return $sect;
    }
    
    
    /**
     * 
     * @param string $ident Entgelt Ident
     * @param string $usage Nutzungsart (ext, int, intext)
     * @return string
     */
    public function getRapSelect($ident,$usage)
    {
    	$productId = $this->getProductId(); 
    	
    	$helper = Mage::helper('virtualgeo/rap');
    	
    	$txt = array();
    	$txt[] = '<select id="'.$ident.$usage.'" name="product[rap]['.$ident.']['.$usage.']" >';
    	$txt[] = '<option value="">-- keine --</option>';
    	foreach ($this->getRapProductCollection() as $rap)
    	{
    		if($helper->findRap($this->getRapRelationCollection(), $rap->getId(), $ident, $usage, false) != null)
    		{
    			$txt[] = '<option selected="selected" value="'.$rap->getId().'">'. $rap->getName() .'</option>';
    		}else{
    			$txt[] = '<option value="'.$rap->getId().'">'. $rap->getName() .'</option>';
    		}
    	}
    	$txt[] = '</select>';
    	
    	return implode(' ',$txt);
    }
    
    
    
    
    protected function _prepareLayout()
    {

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
    
    public function getFieldsHtml()
    {
    	//return $this->getChildHtml('personal_field_box');
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
