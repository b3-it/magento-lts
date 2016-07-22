<?php

class Egovs_EventBundle_Block_Catalog_Product_View_Personal extends Mage_Catalog_Block_Product_View_Abstract
{
	public function getFields()
	{
		$product  =  $this->getProduct();
		if($product)
		{
			return $product->getTypeInstance(false)->getPersonalOptions();
		}
		return array();
	}
		
	
}
