<?php

class Egovs_Extstock_Helper_Data extends Mage_Core_Helper_Abstract
{	
	const DISTRIBUTOR_EDIT_ID = 'exts_distributor_edit';
	const QTY_ORDERED_EDIT_ID = 'exts_qty_ordered_edit';
	const COST_EDIT_ID = 'exts_cost_ordered_edit';
	const DATE_ORDERED_EDIT_ID = 'exts_date_ordered_edit';
	const STORAGE_EDIT_ID = 'exts_storage_edit';
	const RACK_EDIT_ID = 'exts_rack_edit';
	
	//status 
	const ORDERED = 1;
	const DELIVERED = 2;
	
	const REORDER = "reorder";
	
	const LOG_FILE = "egovs.log";
	const EXCEPTION_LOG_FILE = "egovs_exception.log";
	
	/**
	 * Prüft ob das Produkt für die erweiterte Lagerverwaltung geeignet ist.
	 * 
	 * @param integer|Mage_Sales_Model_Order_Item $typeid Typ des Produkts oder Produkt selbst
	 * 
	 * @return boolean
	 */
	public static function checkForUsableProductType($typeid) {
		// TYPE_SIMPLE
		// TYPE_BUNDLE
		// TYPE_CONFIGURABLE
		// TYPE_GROUPED
		// TYPE_VIRTUAL
		
		if ($typeid instanceof Mage_Sales_Model_Order_Item) {
			$typeid = $typeid->getProductType();
		}
				
		if ($typeid) {
			if (($typeid != Mage_Catalog_Model_Product_Type::TYPE_GROUPED)
				&& ($typeid != Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE)
				&& ($typeid != Mage_Catalog_Model_Product_Type::TYPE_BUNDLE)
			) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Prüft ob das Produkt unter Lagerverwaltung steht
	 * 
	 * @param int|Mage_Catalog_Model_Product $product Produkt
	 * 
	 * @return boolean
	 */
	public static function isManagedStock($product) {
		if ($product instanceof Mage_Catalog_Model_Product) {
			$product = $product->getId();
		}
		
		/* @var $stockItem Mage_CatalogInventory_Model_Stock_Item */
		$stockItem = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
		
		if ($stockItem && $stockItem->getManageStock()) {
			Mage::log("extstock::Product [Product ID: $product] is managed by stock.",
					Zend_Log::INFO,
					Egovs_Extstock_Helper_Data::LOG_FILE);
			return true;
		}
		Mage::log("extstock::Product [Product ID: $product] is not managed by stock.",
				Zend_Log::INFO,
				Egovs_Extstock_Helper_Data::LOG_FILE)
		;
		return false;
	}
}