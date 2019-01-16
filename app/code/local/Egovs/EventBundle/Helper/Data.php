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

    /**
     * @param $item
     *
     * @return string
     */
	public function getAdditionalPriceInfo($item) {
	    if (!($item instanceof Varien_Object)) {
	        return '';
        }

        $text = '';

        if (((float)$item->getPrice() > 0.009) || (Mage::getStoreConfig('eventbundle/display_prices/cart_sub_price_eq_null') == 1)) {
            $text .= ' ( ' . Mage::helper('core')->currency($item->getPrice());
            if (Mage::helper('core')->isModuleEnabled('Egovs_Ready')) {
                $text .= sprintf(' + %s', Mage::helper('core')->currency($item->getTaxAmount()));
                if (Mage::getStoreConfigFlag('catalog/price/display_formatted_tax_rate_below_price')) {
                    $text .= sprintf(' (%s%%', number_format($item->getTaxPercent(), 2));
                }
                $text .= sprintf(' %s', $this->__('VAT'));
            } elseif (Mage::getStoreConfig('tax/cart_display/zero_tax') == 1) {
                $text .= ' + ' . Mage::helper('core')->currency($item->getTaxAmount())
                    . ' (' . number_format($item->getTaxPercent(), 2) . "%)";
            }
            $text .= ')';
        }

        return $text;
    }
}