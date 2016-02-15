<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
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
            if ($this->_helper->isCrossBorderTradeEnabled($store)) {
                $this->_areTaxRequestsSimilar = true;
            } else {
                $this->_areTaxRequestsSimilar =
                        $this->_calculator->compareRequests($storeTaxRequest, $addressTaxRequest);
            }
        }

        $shipping           = $taxShipping = $address->getShippingAmount();
        $baseShipping       = $baseTaxShipping = $address->getBaseShippingAmount();
        $rate               = $calc->getRate($addressTaxRequest);
        if ($priceIncludesTax) {
            if ($this->_areTaxRequestsSimilar) {
                $tax            = $this->_round($calc->calcTaxAmount($shipping, $rate, true, false), $rate, true);
                $baseTax        = $this->_round(
                    $calc->calcTaxAmount($baseShipping, $rate, true, false), $rate, true, 'base');
                $taxShipping    = $shipping;
                $baseTaxShipping = $baseShipping;
                $shipping       = $shipping - $tax;
                $baseShipping   = $baseShipping - $baseTax;
                $taxable        = $taxShipping;
                $baseTaxable    = $baseTaxShipping;
                $isPriceInclTax = true;
                $address->setTotalAmount('shipping', $shipping);
                $address->setBaseTotalAmount('shipping', $baseShipping);
            } else {
                $storeRate      = $calc->getStoreRate($addressTaxRequest, $store);
                $storeTax       = $calc->calcTaxAmount($shipping, $storeRate, true, false);
                $baseStoreTax   = $calc->calcTaxAmount($baseShipping, $storeRate, true, false);
                $shipping       = $calc->round($shipping - $storeTax);
                $baseShipping   = $calc->round($baseShipping - $baseStoreTax);
                $tax            = $this->_round($calc->calcTaxAmount($shipping, $rate, false, false), $rate, true);
                $baseTax        = $this->_round(
                    $calc->calcTaxAmount($baseShipping, $rate, false, false), $rate, true, 'base');
                $taxShipping    = $shipping + $tax;
                $baseTaxShipping = $baseShipping + $baseTax;
                $taxable        = $taxShipping;
                $baseTaxable    = $baseTaxShipping;
                $isPriceInclTax = true;
                $address->setTotalAmount('shipping', $shipping);
                $address->setBaseTotalAmount('shipping', $baseShipping);
            }
        } else {
            $appliedRates = $calc->getAppliedRates($addressTaxRequest);
            $taxes = array();
            $baseTaxes = array();
            foreach ($appliedRates as $appliedRate) {
                $taxRate = $appliedRate['percent'];
                $taxId = $appliedRate['id'];
                $taxes[] = $this->_round($calc->calcTaxAmount($shipping, $taxRate, false, false), $taxId, false);
                $baseTaxes[] = $this->_round(
                    $calc->calcTaxAmount($baseShipping, $taxRate, false, false), $taxId, false, 'base');
            }
            $tax            = array_sum($taxes);
            $baseTax        = array_sum($baseTaxes);
            $taxShipping    = $shipping + $tax;
            $baseTaxShipping = $baseShipping + $baseTax;
            $taxable        = $shipping;
            $baseTaxable    = $baseShipping;
            $isPriceInclTax = false;
            $address->setTotalAmount('shipping', $shipping);
            $address->setBaseTotalAmount('shipping', $baseShipping);
        }
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