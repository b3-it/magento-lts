<?php
/**
 * 
 *  @category Egovs
 *  @package  Egovs_EventBundle
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function loadStockItem($product)
	{
		/* @var $item Mage_Catalog_Model_Product */ 
 		$stockItem = $product->getStockItem();
 		if(!$stockItem->getId())
 		{
 			/* @var $stockItem Mage_CatalogInventory_Model_Stock */
 			$stockItem = Mage::getModel('cataloginventory/stock_item')->load($product->getId(),'product_id');
 			$product->setStockItem($stockItem);
 		}
 		return $product;
	}
}