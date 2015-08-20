<?php
class Egovs_GermanTax_Model_Tax_Sales_Total_Quote_Shipping extends Mage_Tax_Model_Sales_Total_Quote_Shipping
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		parent::__construct();
        $this->_calculator  = Mage::getSingleton('germantax/tax_calculation');
	}
	
	protected function _getShippingTaxClass($shippingTaxClass) {
		return Mage::getSingleton('germantax/calculation')->getShippingTaxClass($shippingTaxClass, $this->_getAddress());
	}
	
	/**
	 * Collect totals information about shipping
	 *
	 * @param Mage_Sales_Model_Quote_Address $address Adresse
	 * 
	 * @return  Mage_Sales_Model_Quote_Address_Total_Shipping
	 */
	public function collect(Mage_Sales_Model_Quote_Address $address)
	{
		Mage_Sales_Model_Quote_Address_Total_Abstract::collect($address);
		
		$calc               = $this->_calculator;
		$store              = $address->getQuote()->getStore();
		$storeTaxRequest    = $calc->getRateOriginRequest($store);
		$addressTaxRequest  = $calc->getRateRequest(
				$address,
				$address->getQuote()->getBillingAddress(),
				$address->getQuote()->getCustomerTaxClassId(),
				$store
		);
	
		$shippingTaxClass = $this->_getShippingTaxClass($this->_config->getShippingTaxClass($store));
		
		$storeTaxRequest->setProductClassId($shippingTaxClass);
		$addressTaxRequest->setProductClassId($shippingTaxClass);
	
		$priceIncludesTax = $this->_config->shippingPriceIncludesTax($store);
		if ($priceIncludesTax) {
			$this->_areTaxRequestsSimilar = $calc->compareRequests($addressTaxRequest, $storeTaxRequest);
		}
	
		$shipping           = $taxShipping = $address->getShippingAmount();
		$baseShipping       = $baseTaxShipping = $address->getBaseShippingAmount();
		$rate               = $calc->getRate($addressTaxRequest);
		if ($priceIncludesTax) {
			if ($this->_areTaxRequestsSimilar) {
				$tax            = $this->_round($calc->calcTaxAmount($shipping, $rate, true, false), $rate, true);
				$baseTax        = $this->_round($calc->calcTaxAmount($baseShipping, $rate, true, false), $rate, true, 'base');
				$taxShipping    = $shipping;
				$baseTaxShipping= $baseShipping;
				$shipping       = $shipping - $tax;
				$baseShipping   = $baseShipping - $baseTax;
				$taxable        = $taxShipping;
				$baseTaxable    = $baseTaxShipping;
				$isPriceInclTax = true;
			} else {
				$storeRate      = $calc->getStoreRate($addressTaxRequest, $store);
				$storeTax       = $calc->calcTaxAmount($shipping, $storeRate, true, false);
				$baseStoreTax   = $calc->calcTaxAmount($baseShipping, $storeRate, true, false);
				$shipping       = $calc->round($shipping - $storeTax);
				$baseShipping   = $calc->round($baseShipping - $baseStoreTax);
				$tax            = $this->_round($calc->calcTaxAmount($shipping, $rate, false, false), $rate, false);
				$baseTax        = $this->_round($calc->calcTaxAmount($baseShipping, $rate, false, false), $rate, false, 'base');
				$taxShipping    = $shipping + $tax;
				$baseTaxShipping= $baseShipping + $baseTax;
				$taxable        = $shipping;
				$baseTaxable    = $baseShipping;
				$isPriceInclTax = false;
			}
		} else {
			$tax            = $this->_round($calc->calcTaxAmount($shipping, $rate, false, false), $rate, false);
			$baseTax        = $this->_round($calc->calcTaxAmount($baseShipping, $rate, false, false), $rate, false, 'base');
			$taxShipping    = $shipping + $tax;
			$baseTaxShipping= $baseShipping + $baseTax;
			$taxable        = $shipping;
			$baseTaxable    = $baseShipping;
			$isPriceInclTax = false;
		}
		$address->setTotalAmount('shipping', $shipping);
		$address->setBaseTotalAmount('shipping', $baseShipping);
		$address->setShippingInclTax($taxShipping);
		$address->setBaseShippingInclTax($baseTaxShipping);
		$address->setShippingTaxable($taxable);
		$address->setBaseShippingTaxable($baseTaxable);
		$address->setIsShippingInclTax($isPriceInclTax);
		if ($this->_config->discountTax($store)) {
			$address->setShippingAmountForDiscount($taxShipping);
			$address->setBaseShippingAmountForDiscount($baseTaxShipping);
		}
		return $this;
	}
}