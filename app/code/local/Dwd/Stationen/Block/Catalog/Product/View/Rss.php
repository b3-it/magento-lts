<?php
class Dwd_Stationen_Block_Catalog_Product_View_Rss extends Dwd_Stationen_Block_Catalog_Product_View_Abstract
{
	public function __construct()
    {
		//parent::_prepareLayout();
		$this->setTemplate('dwd/stationen/catalog/product/view/rss.phtml');
		
		return $this;
    }
    
    public function getProduct()
    {
    	$id = $this->getRequest()->getParam('product_id');
    	if($id)
    	{
    		return Mage::getModel('catalog/product')->load($id);
    	}
    }
    
    protected function getCategoryId()
	{
		return  $this->getRequest()->getParam('category_id');
	}
	
    
}