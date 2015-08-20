<?php
class Egovs_GermanTax_Model_Tax_Sales_Total_Quote_Nominal_Tax extends Mage_Tax_Model_Sales_Total_Quote_Nominal_Tax
{
	/**
	 * Class constructor
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->_calculator  = Mage::getSingleton('germantax/tax_calculation');
	}
	
	/**
	 * Tax caclulation for shipping price
	 *
	 * @param Mage_Sales_Model_Quote_Address $address        Adress-Item
	 * @param Varien_Object                  $taxRateRequest Tax Request
	 * 
	 * @return  Mage_Tax_Model_Sales_Total_Quote
	 */
	protected function _calculateShippingTax(Mage_Sales_Model_Quote_Address $address, $taxRateRequest) {
		$shippingTaxClass = Mage::getSingleton('germantax/calculation')->getShippingTaxClass($this->_config->getShippingTaxClass($this->_store), $address);
		$taxRateRequest->setProductClassId($shippingTaxClass);
		$rate           = $this->_calculator->getRate($taxRateRequest);
		$inclTax        = $address->getIsShippingInclTax();
		$shipping       = $address->getShippingTaxable();
		$baseShipping   = $address->getBaseShippingTaxable();
		$rateKey        = (string)$rate;
	
		$hiddenTax      = null;
		$baseHiddenTax  = null;
		switch ($this->_helper->getCalculationSequence($this->_store)) {
			case Mage_Tax_Model_Calculation::CALC_TAX_BEFORE_DISCOUNT_ON_EXCL:
			case Mage_Tax_Model_Calculation::CALC_TAX_BEFORE_DISCOUNT_ON_INCL:
				$tax        = $this->_calculator->calcTaxAmount($shipping, $rate, $inclTax, false);
				$baseTax    = $this->_calculator->calcTaxAmount($baseShipping, $rate, $inclTax, false);
				break;
			case Mage_Tax_Model_Calculation::CALC_TAX_AFTER_DISCOUNT_ON_EXCL:
			case Mage_Tax_Model_Calculation::CALC_TAX_AFTER_DISCOUNT_ON_INCL:
				$discountAmount     = $address->getShippingDiscountAmount();
				$baseDiscountAmount = $address->getBaseShippingDiscountAmount();
				$tax = $this->_calculator->calcTaxAmount(
						$shipping - $discountAmount,
						$rate,
						$inclTax,
						false
				);
				$baseTax = $this->_calculator->calcTaxAmount(
						$baseShipping - $baseDiscountAmount,
						$rate,
						$inclTax,
						false
				);
				break;
		}
	
		if ($this->_config->getAlgorithm($this->_store) == Mage_Tax_Model_Calculation::CALC_TOTAL_BASE) {
			$tax        = $this->_deltaRound($tax, $rate, $inclTax);
			$baseTax    = $this->_deltaRound($baseTax, $rate, $inclTax, 'base');
		} else {
			$tax        = $this->_calculator->round($tax);
			$baseTax    = $this->_calculator->round($baseTax);
		}
	
		if ($inclTax && !empty($discountAmount)) {
			$hiddenTax      = $this->_calculator->calcTaxAmount($discountAmount, $rate, $inclTax, false);
			$baseHiddenTax  = $this->_calculator->calcTaxAmount($baseDiscountAmount, $rate, $inclTax, false);
			$this->_hiddenTaxes[] = array(
					'rate_key'   => $rateKey,
					'value'      => $hiddenTax,
					'base_value' => $baseHiddenTax,
					'incl_tax'   => $inclTax,
			);
		}
	
		$this->_addAmount(max(0, $tax));
		$this->_addBaseAmount(max(0, $baseTax));
		$address->setShippingTaxAmount(max(0, $tax));
		$address->setBaseShippingTaxAmount(max(0, $baseTax));
		$applied = $this->_calculator->getAppliedRates($taxRateRequest);
		$this->_saveAppliedTaxes($address, $applied, $tax, $baseTax, $rate);
	
		return $this;
	}
	
	/**
	 * Calculate address tax amount based on one unit price and tax amount
	 *
	 * @param   Mage_Sales_Model_Quote_Address $address
	 * @return  Mage_Tax_Model_Sales_Total_Quote
	 */
	protected function _unitBaseCalculation(Mage_Sales_Model_Quote_Address $address, $taxRateRequest)
	{
		$items = $this->_getAddressItems($address);
		$itemTaxGroups  = array();
		foreach ($items as $item) {
			if ($item->getParentItem()) {
				continue;
			}
	
			if ($item->getHasChildren() && $item->isChildrenCalculated()) {
				foreach ($item->getChildren() as $child) {
					$taxRateRequest->setIsVirtual($child->getProduct()->getIsVirtual());
					
					$taxRateRequest->setProductClassId($child->getProduct()->getTaxClassId());
					
					$rate = $this->_calculator->getRate($taxRateRequest);
					$this->_calcUnitTaxAmount($child, $rate);
					$this->_addAmount($child->getTaxAmount());
					$this->_addBaseAmount($child->getBaseTaxAmount());
					$applied = $this->_calculator->getAppliedRates($taxRateRequest);
					if ($rate > 0) {
						$itemTaxGroups[$child->getId()] = $applied;
					}
					$this->_saveAppliedTaxes(
							$address,
							$applied,
							$child->getTaxAmount(),
							$child->getBaseTaxAmount(),
							$rate
					);
					$child->setTaxRates($applied);
				}
				$this->_recalculateParent($item);
			}
			else {
				$taxRateRequest->setIsVirtual($item->getProduct()->getIsVirtual());
				
				$taxRateRequest->setProductClassId($item->getProduct()->getTaxClassId());
				
				$rate = $this->_calculator->getRate($taxRateRequest);
				$this->_calcUnitTaxAmount($item, $rate);
				$this->_addAmount($item->getTaxAmount());
				$this->_addBaseAmount($item->getBaseTaxAmount());
				$applied = $this->_calculator->getAppliedRates($taxRateRequest);
				if ($rate > 0) {
					$itemTaxGroups[$item->getId()] = $applied;
				}
				$this->_saveAppliedTaxes(
						$address,
						$applied,
						$item->getTaxAmount(),
						$item->getBaseTaxAmount(),
						$rate
				);
				$item->setTaxRates($applied);
			}
		}
		if ($address->getQuote()->getTaxesForItems()) {
			$itemTaxGroups += $address->getQuote()->getTaxesForItems();
		}
		$address->getQuote()->setTaxesForItems($itemTaxGroups);
		return $this;
	}
	
	/**
	 * Calculate address total tax based on row total
	 *
	 * @param   Mage_Sales_Model_Quote_Address $address
	 * @param   Varien_Object $taxRateRequest
	 * @return  Mage_Tax_Model_Sales_Total_Quote
	 */
	protected function _rowBaseCalculation(Mage_Sales_Model_Quote_Address $address, $taxRateRequest)
	{
		$items = $this->_getAddressItems($address);
		$itemTaxGroups  = array();
		foreach ($items as $item) {
			if ($item->getParentItem()) {
				continue;
			}
			if ($item->getHasChildren() && $item->isChildrenCalculated()) {
				foreach ($item->getChildren() as $child) {
					$taxRateRequest->setIsVirtual($child->getProduct()->getIsVirtual());
					
					$taxRateRequest->setProductClassId($child->getProduct()->getTaxClassId());
					
					$rate = $this->_calculator->getRate($taxRateRequest);
					$this->_calcRowTaxAmount($child, $rate);
					$this->_addAmount($child->getTaxAmount());
					$this->_addBaseAmount($child->getBaseTaxAmount());
					$applied = $this->_calculator->getAppliedRates($taxRateRequest);
					if ($rate > 0) {
						$itemTaxGroups[$child->getId()] = $applied;
					}
					$this->_saveAppliedTaxes(
							$address,
							$applied,
							$child->getTaxAmount(),
							$child->getBaseTaxAmount(),
							$rate
					);
				}
				$this->_recalculateParent($item);
			}
			else {
				$taxRateRequest->setIsVirtual($item->getProduct()->getIsVirtual());
				
				$taxRateRequest->setProductClassId($item->getProduct()->getTaxClassId());
				
				$rate = $this->_calculator->getRate($taxRateRequest);
				$this->_calcRowTaxAmount($item, $rate);
				$this->_addAmount($item->getTaxAmount());
				$this->_addBaseAmount($item->getBaseTaxAmount());
				$applied = $this->_calculator->getAppliedRates($taxRateRequest);
				if ($rate > 0) {
					$itemTaxGroups[$item->getId()] = $applied;
				}
				$this->_saveAppliedTaxes(
						$address,
						$applied,
						$item->getTaxAmount(),
						$item->getBaseTaxAmount(),
						$rate
				);
			}
		}
	
		if ($address->getQuote()->getTaxesForItems()) {
			$itemTaxGroups += $address->getQuote()->getTaxesForItems();
		}
		$address->getQuote()->setTaxesForItems($itemTaxGroups);
		return $this;
	}
	
	/**
	 * Calculate address total tax based on address subtotal
	 *
	 * @param   Mage_Sales_Model_Quote_Address $address
	 * @param   Varien_Object $taxRateRequest
	 * @return  Mage_Tax_Model_Sales_Total_Quote
	 */
	protected function _totalBaseCalculation(Mage_Sales_Model_Quote_Address $address, $taxRateRequest)
	{
		$items          = $this->_getAddressItems($address);
		$store          = $address->getQuote()->getStore();
		$taxGroups      = array();
		$itemTaxGroups  = array();
	
		$inclTax = false;
		foreach ($items as $item) {
			if ($item->getParentItem()) {
				continue;
			}
	
			if ($item->getHasChildren() && $item->isChildrenCalculated()) {
				foreach ($item->getChildren() as $child) {
					$taxRateRequest->setIsVirtual($child->getProduct()->getIsVirtual());
					
					$taxRateRequest->setProductClassId($child->getProduct()->getTaxClassId());
					$rate = $this->_calculator->getRate($taxRateRequest);
					$applied_rates = $this->_calculator->getAppliedRates($taxRateRequest);
					$taxGroups[(string)$rate]['applied_rates'] = $applied_rates;
					$this->_aggregateTaxPerRate($child, $rate, $taxGroups);
					$inclTax = $child->getIsPriceInclTax();
					if ($rate > 0) {
						$itemTaxGroups[$child->getId()] = $applied_rates;
					}
				}
				$this->_recalculateParent($item);
			} else {
				$taxRateRequest->setIsVirtual($item->getProduct()->getIsVirtual());
				
				$taxRateRequest->setProductClassId($item->getProduct()->getTaxClassId());
				$rate = $this->_calculator->getRate($taxRateRequest);
				$applied_rates = $this->_calculator->getAppliedRates($taxRateRequest);
				$taxGroups[(string)$rate]['applied_rates'] = $applied_rates;
				$this->_aggregateTaxPerRate($item, $rate, $taxGroups);
				$inclTax = $item->getIsPriceInclTax();
				if ($rate > 0) {
					$itemTaxGroups[$item->getId()] = $applied_rates;
				}
			}
		}
	
		if ($address->getQuote()->getTaxesForItems()) {
			$itemTaxGroups += $address->getQuote()->getTaxesForItems();
		}
		$address->getQuote()->setTaxesForItems($itemTaxGroups);
	
		foreach ($taxGroups as $rateKey => $data) {
			$rate = (float) $rateKey;
			$totalTax = $this->_calculator->calcTaxAmount(array_sum($data['totals']), $rate, $inclTax);
			$baseTotalTax = $this->_calculator->calcTaxAmount(array_sum($data['base_totals']), $rate, $inclTax);
			$this->_addAmount($totalTax);
			$this->_addBaseAmount($baseTotalTax);
			$this->_saveAppliedTaxes($address, $data['applied_rates'], $totalTax, $baseTotalTax, $rate);
		}
		return $this;
	}
}