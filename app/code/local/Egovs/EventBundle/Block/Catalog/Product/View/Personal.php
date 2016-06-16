<?php

class Egovs_EventBundle_Block_Catalog_Product_View_Personal extends Mage_Catalog_Block_Product_View_Abstract
{
	public function getFields()
	{
		$fields = array();
		$collection = Mage::getModel('eventbundle/personal_option')->getCollection();
		$collection->getSelect()
			->where('product_id='.$this->getProductId())
			->order('pos');
		$collection->setStoreId($this->getStoreId());
		return $collection->getItems();
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
	
	private function getStoreId()
	{
		$storeId   = Mage::app()->getStore()->getId();
		return $storeId;
	
	}

}
