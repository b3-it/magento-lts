<?php
/**
 * Egovs GermanTax
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_GermanTax
 * @name       	Egovs_GermanTax_Helper_Data
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Helper_Data extends Mage_Tax_Helper_Data
{
	/**
	 * Get tax calculation object
	 *
	 * @return  Mage_Tax_Model_Calculation
	 */
	public function getCalculator()
	{
		if ($this->_calculator === null) {
			$this->_calculator = Mage::getSingleton('germantax/tax_calculation');
		}
		return $this->_calculator;
	}
	
	/**
	 * Get product price with all tax settings processing
	 *
	 * @param   Mage_Catalog_Model_Product $product
	 * @param   float $price inputed product price
	 * @param   bool $includingTax return price include tax flag
	 * @param   null|Mage_Customer_Model_Address $shippingAddress
	 * @param   null|Mage_Customer_Model_Address $billingAddress
	 * @param   null|int $ctc customer tax class
	 * @param   mixed $store
	 * @param   bool $priceIncludesTax flag what price parameter contain tax
	 * @return  float
	 */

	

	public function getPrice($product, $price, $includingTax = null, $shippingAddress = null, $billingAddress = null,
			$ctc = null, $store = null, $priceIncludesTax = null, $roundPrice = true
	) {
		if (!$price) {
			return $price;
		}
		$store = Mage::app()->getStore($store);
		if (!$this->needPriceConversion($store)) {
			return $store->roundPrice($price);
		}
		if (is_null($priceIncludesTax)) {
			$priceIncludesTax = $this->priceIncludesTax($store);
		}
	
		$percent = $product->getTaxPercent();
		$includingPercent = null;
	
		$taxClassId = $product->getTaxClassId();
		/* @var $session Mage_Customer_Model_Session */ 
		$session = Mage::getSingleton('customer/session');
		if (is_null($percent) || ($product->getIsVirtual() && $session->isLoggedIn())) {
			if ($taxClassId) {
				$request = $this->getCalculator()
					->getRateRequest($shippingAddress, $billingAddress, $ctc, $store);
				$request->setIsVirtual($product->getIsVirtual());
	
				$percent = $this->getCalculator()
					->getRate($request->setProductClassId($taxClassId));
			}
		}
		if ($taxClassId && $priceIncludesTax) {
			$request = $this->getCalculator()->getRateRequest(false, false, false, $store);
			$includingPercent = $this->getCalculator()
				->getRate($request->setProductClassId($taxClassId));
		}
	
		if ($percent === false || is_null($percent)) {
			if ($priceIncludesTax && !$includingPercent) {
				return $price;
			}
		}
	
		$product->setTaxPercent($percent);
	
		if (!is_null($includingTax)) {
			if ($priceIncludesTax) {
				if ($includingTax) {
					/**
					 * Recalculate price include tax in case of different rates
					 */
					if ($includingPercent != $percent) {
						$price = $this->_calculatePrice($price, $includingPercent, false);
						/**
						 * Using regular rounding. Ex:
						 * price incl tax   = 52.76
						 * store tax rate   = 19.6%
						 * customer tax rate= 19%
						 *
						 * price excl tax = 52.76 / 1.196 = 44.11371237 ~ 44.11
						 * tax = 44.11371237 * 0.19 = 8.381605351 ~ 8.38
						 * price incl tax = 52.49531773 ~ 52.50 != 52.49
						 *
						 * that why we need round prices excluding tax before applying tax
						 * this calculation is used for showing prices on catalog pages
						*/
						if ($percent != 0) {
							$price = $this->getCalculator()->round($price);
							$price = $this->_calculatePrice($price, $percent, true);
						}
					}
				} else {
					$price = $this->_calculatePrice($price, $includingPercent, false);
				}
			} else {
				if ($includingTax) {
					$price = $this->_calculatePrice($price, $percent, true);
				}
			}
		} else {
			if ($priceIncludesTax) {
				switch ($this->getPriceDisplayType($store)) {
					case Mage_Tax_Model_Config::DISPLAY_TYPE_EXCLUDING_TAX:
					case Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH:
						$price = $this->_calculatePrice($price, $includingPercent, false);
						break;
	
					case Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX:
						$price = $this->_calculatePrice($price, $includingPercent, false);
						$price = $this->_calculatePrice($price, $percent, true);
						break;
				}
			} else {
				switch ($this->getPriceDisplayType($store)) {
					case Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX:
						$price = $this->_calculatePrice($price, $percent, true);
						break;
	
					case Mage_Tax_Model_Config::DISPLAY_TYPE_BOTH:
					case Mage_Tax_Model_Config::DISPLAY_TYPE_EXCLUDING_TAX:
						break;
				}
			}
		}
		if ($roundPrice) {
            return $store->roundPrice($price);
        } else {
            return $price;
        }
	}
}