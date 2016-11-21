<?php
class Egovs_Base_Block_Catalog_Product_List extends Mage_Catalog_Block_Product_List
{
	/**
	 * Prüft ob ein Produkt als NEU gekennzeichnet ist
	 * 
	 * @param Mage_Catalog_Model_Product $product
	 * @return boolean
	 */
	public function isProductNew($product) {
		return Mage::helper('egovsbase/catalog_product_data')->isProductNew($product);
	}
}