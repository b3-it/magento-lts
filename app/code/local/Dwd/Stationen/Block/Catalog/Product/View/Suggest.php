<?php
class Dwd_Stationen_Block_Catalog_Product_View_Suggest extends Dwd_Stationen_Block_Catalog_Product_View_Abstract
{
	public function _prepareLayout()
    {
		parent::_prepareLayout();
		$this->setTemplate('dwd/stationen/catalog/product/view/map.phtml');
		
		return $this;
    }
    
	public function getRssUrl()
    {
    	return $this->getUrl('fstationen/liste/rss');
    }
    
}