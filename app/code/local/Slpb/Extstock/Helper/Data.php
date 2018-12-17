<?php

class Slpb_Extstock_Helper_Data extends Mage_Core_Helper_Abstract
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
	
	const LOG_FILE = "Slpb.log";
	const EXCEPTION_LOG_FILE = "Slpb_exception.log";
	
	
	
	private static $_SelectedWarningGridParams = null;
	
	/**
	 * Prüft ob das Produkt für die erweiterte Lagerverwaltung geeignet ist.
	 * @param integer|Mage_Sales_Model_Order_Item $typeid Typ des Produkts oder Produkt selbst
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
			if(($typeid != Mage_Catalog_Model_Product_Type::TYPE_GROUPED) &&
			($typeid != Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) &&
			($typeid != Mage_Catalog_Model_Product_Type::TYPE_BUNDLE)) {
				return true;
			}
		}
		return false;
	}
	
	
	/**
	 * Erzeugen eines 2-Dim Arrays für die Überegabeparameter des 
	 * Warning Grids als $res[product_id_stock_id] = array(amount=>,product_id=>)
	 * @param GET Parameter $params
	 */
	public static function getWarningGridParamAsArray($params)
	{
		if(self::$_SelectedWarningGridParams == null)
		{
			//Produktids kommen als concat(product_id,"_",stock_id)
			self::$_SelectedWarningGridParams = array();
			
			$products = explode(',',$params['product_keys']);
			$destinations = explode(',',$params['destination']);
			$amounts = explode(',',$params['amount']);
			$packages = explode(',',$params['package']);
			
			$selected_ids = array();
			$selected = explode(',',$params['product_id']);
			foreach($selected as $t)
			{
				$t = explode('_',$t);
				$selected_ids[] = $t[0];
			}
			
			
			for($i = 0, $iMax = count($products); $i < $iMax; $i++)
			{
				$product = $products[$i];
				$destination = $destinations[$i];
				$amount = $amounts[$i];
				$package = $packages[$i];
				if(in_array($product,$selected_ids))
				{
						self::$_SelectedWarningGridParams[$product."_"+$destination] = array('qty'=>$amount,'destination'=>$destination,'product'=>$product);
				}
			}
		}
		
		return self::$_SelectedWarningGridParams; 
	}
	
	
	
}