<?php
abstract class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Abstract extends Mage_Catalog_Block_Product_View_Abstract
{
	
	public function getOptions()
	{
		$productId = $this->getProduct()->getId();
		$storeId = Mage::app()->getStore()->getId();
		$collection = Mage::getModel($this->_component_model_type)->getOptions4Product($productId,$storeId);
		
		return $collection->getItems();
	}
}