<?php
/**
 * 
 *  Preis Model für Veranstaltungsprodukte
 *  @category Egovs
 *  @package  Egovs_EventBundle
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Model_Product_Price extends Mage_Bundle_Model_Product_Price
{
 
	/**
	 * Retrieve Price with take into account tier price
	 *
	 * @param  Mage_Catalog_Model_Product $product
	 * @param  string|null                $which
	 * @param  bool|null                  $includeTax
	 * @param  bool                       $takeTierPrice
	 * @return float|array
	 */
	public function getTotalPrices($product, $which = null, $includeTax = null, $takeTierPrice = true)
	{
		// check calculated price index
		if ($product->getData('min_price') && $product->getData('max_price')) {
			$minimalPrice = Mage::helper('tax')->getPrice($product, $product->getData('min_price'), $includeTax);
			$maximalPrice = Mage::helper('tax')->getPrice($product, $product->getData('max_price'), $includeTax);
			$this->_isPricesCalculatedByIndex = true;
		} else {
			/**
			 * Check if product price is fixed
			 */
			$finalPrice = $product->getFinalPrice();
			if ($product->getPriceType() == self::PRICE_TYPE_FIXED) {
				$minimalPrice = $maximalPrice = Mage::helper('tax')->getPrice($product, $finalPrice, $includeTax);
			} else { // PRICE_TYPE_DYNAMIC
				$minimalPrice = $maximalPrice = 0;
			}
	
			$options = $this->getOptions($product);
			$minPriceFounded = false;
	
			if ($options) {
				foreach ($options as $option) {
					/* @var $option Mage_Bundle_Model_Option */
					$selections = $option->getSelections();
					if ($selections) {
						$selectionMinimalPrices = array();
						$selectionMaximalPrices = array();
	
						foreach ($option->getSelections() as $selection) {
							/* @var $selection Mage_Bundle_Model_Selection */
							if (!$selection->isSalable()) {
								/**
								 * @todo CatalogInventory Show out of stock Products
								 */
								continue;
							}
	
							$qty = $selection->getSelectionQty();
	
							$item = $product->getPriceType() == self::PRICE_TYPE_FIXED ? $product : $selection;
	
							$selectionMinimalPrices[] = Mage::helper('tax')->getPrice(
									$item,
									$this->getSelectionFinalTotalPrice($product, $selection, 1, $qty, true, $takeTierPrice),
									$includeTax
							);
							$selectionMaximalPrices[] = Mage::helper('tax')->getPrice(
									$item,
									$this->getSelectionFinalTotalPrice($product, $selection, 1, null, true, $takeTierPrice),
									$includeTax
							);
						}
	
						if (count($selectionMinimalPrices)) {
							$selMinPrice = min($selectionMinimalPrices);
							if ($option->getRequired() == 1) {
								$minimalPrice += $selMinPrice;
								$minPriceFounded = true;
							} elseif (true !== $minPriceFounded) {
								$selMinPrice += $minimalPrice;
								$minPriceFounded = (false === $minPriceFounded)
								? $selMinPrice
								: min($minPriceFounded, $selMinPrice);
							}
	
							if ($option->isMultiSelection()) {
								$maximalPrice += array_sum($selectionMaximalPrices);
							} else {
								$maximalPrice += max($selectionMaximalPrices);
							}
						}
					}
				}
			}
			// condition is TRUE when all product options are NOT required
			if (!is_bool($minPriceFounded)) {
				$minimalPrice = $minPriceFounded;
			}
	
			$customOptions = $product->getOptions();
			if ($product->getPriceType() == self::PRICE_TYPE_FIXED && $customOptions) {
				foreach ($customOptions as $customOption) {
					/* @var $customOption Mage_Catalog_Model_Product_Option */
					$values = $customOption->getValues();
					if ($values) {
						$prices = array();
						foreach ($values as $value) {
							/* @var $value Mage_Catalog_Model_Product_Option_Value */
							$valuePrice = $value->getPrice(true);
	
							$prices[] = $valuePrice;
						}
						if (count($prices)) {
							if ($customOption->getIsRequire()) {
								$minimalPrice += Mage::helper('tax')->getPrice($product, min($prices), $includeTax);
							}
	
							$multiTypes = array(
									//Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN,
									Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX,
									Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE
							);
	
							if (in_array($customOption->getType(), $multiTypes)) {
								$maximalValue = array_sum($prices);
							} else {
								$maximalValue = max($prices);
							}
							$maximalPrice += Mage::helper('tax')->getPrice($product, $maximalValue, $includeTax);
						}
					} else {
						$valuePrice = $customOption->getPrice(true);
	
						if ($customOption->getIsRequire()) {
							$minimalPrice += Mage::helper('tax')->getPrice($product, $valuePrice, $includeTax);
						}
						$maximalPrice += Mage::helper('tax')->getPrice($product, $valuePrice, $includeTax);
					}
				}
			}
			$this->_isPricesCalculatedByIndex = false;
		}
	
		if ($which == 'max') {
			return $maximalPrice;
		} else if ($which == 'min') {
			return $minimalPrice;
		}
	
		return array($minimalPrice, $maximalPrice);
	}
	
}
