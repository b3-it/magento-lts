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
		if (!$product || !($product instanceof Mage_Catalog_Model_Product)) {
			return false;
		}
		
		$currentDate = Mage::app()->getLocale()->date();
			
		$_newFromDate = $product->getNewsFromDate();
		$_newToDate = $product->getNewsToDate();
		
		if (!$_newFromDate && !$_newToDate) {
			return false;
		}
		
		$_newFromDate = Mage::app()->getLocale()->date($_newFromDate);
		$_newToDate = Mage::app()->getLocale()->date($_newToDate)
			->setTime('23:59:59');
		
		if ($currentDate->compare($_newFromDate) < 0) {
			return false;
		}
		
		if ($currentDate->compare($_newToDate) > 0) {
			return false;
		}
		
		return true;
	}
}