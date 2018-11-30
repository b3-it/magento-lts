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
	 * @return  Mage_Tax_Model_Sales_Total_Quote_Nominal_Tax
	 */
	protected function _calculateShippingTax(Mage_Sales_Model_Quote_Address $address, $taxRateRequest)
	{
        $shippingTaxClass = Mage::getSingleton('germantax/calculation')->getShippingTaxClass($this->_config->getShippingTaxClass($this->_store), $address);
		$taxRateRequest->setProductClassId($shippingTaxClass);
		
        $rate = $this->_calculator->getRate($taxRateRequest);
        $inclTax = $address->getIsShippingInclTax();

        $address->setShippingTaxAmount(0);
        $address->setBaseShippingTaxAmount(0);
        $address->setShippingHiddenTaxAmount(0);
        $address->setBaseShippingHiddenTaxAmount(0);
        $appliedRates = $this->_calculator->getAppliedRates($taxRateRequest);
        if ($inclTax) {
            $this->_calculateShippingTaxByRate($address, $rate, $appliedRates);
        } else {
            foreach ($appliedRates as $appliedRate) {
                $taxRate = $appliedRate['percent'];
                $taxId = $appliedRate['id'];
                $this->_calculateShippingTaxByRate($address, $taxRate, array($appliedRate), $taxId);
            }
        }
        return $this;
    }
	
	/**
	 * Calculate address tax amount based on one unit price and tax amount
	 *
	 * @param   Mage_Sales_Model_Quote_Address $address
	 * @return  Mage_Tax_Model_Sales_Total_Quote_Nominal_Tax
	 */
	protected function _unitBaseCalculation(Mage_Sales_Model_Quote_Address $address, $taxRateRequest)
    {
        $items = $this->_getAddressItems($address);
        $itemTaxGroups = array();
        $store = $address->getQuote()->getStore();
        $catalogPriceInclTax = $this->_config->priceIncludesTax($store);

        foreach ($items as $item) {
            if ($item->getParentItem()) {
                continue;
            }

            if ($item->getHasChildren() && $item->isChildrenCalculated()) {
                foreach ($item->getChildren() as $child) {
                	$taxRateRequest->setIsVirtual($child->getProduct()->getIsVirtual());
                	
                    $this->_unitBaseProcessItemTax(
                        $address, $child, $taxRateRequest, $itemTaxGroups, $catalogPriceInclTax);
                }
                $this->_recalculateParent($item);
            } else {
            	$taxRateRequest->setIsVirtual($item->getProduct()->getIsVirtual());
            	
                $this->_unitBaseProcessItemTax(
                    $address, $item, $taxRateRequest, $itemTaxGroups, $catalogPriceInclTax);
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
	 * @return  Mage_Tax_Model_Sales_Total_Quote_Nominal_Tax
	 */
	protected function _rowBaseCalculation(Mage_Sales_Model_Quote_Address $address, $taxRateRequest)
    {
        $items = $this->_getAddressItems($address);
        $itemTaxGroups = array();
        $store = $address->getQuote()->getStore();
        $catalogPriceInclTax = $this->_config->priceIncludesTax($store);

        foreach ($items as $item) {
            if ($item->getParentItem()) {
                continue;
            }
            if ($item->getHasChildren() && $item->isChildrenCalculated()) {
                foreach ($item->getChildren() as $child) {
                	$taxRateRequest->setIsVirtual($child->getProduct()->getIsVirtual());
                	
                    $this->_rowBaseProcessItemTax(
                        $address, $child, $taxRateRequest, $itemTaxGroups, $catalogPriceInclTax);
                }
                $this->_recalculateParent($item);
            } else {
            	$taxRateRequest->setIsVirtual($item->getProduct()->getIsVirtual());
            	
                $this->_rowBaseProcessItemTax(
                    $address, $item, $taxRateRequest, $itemTaxGroups, $catalogPriceInclTax);
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
	 * @return  Mage_Tax_Model_Sales_Total_Quote_Nominal_Tax
	 */
	protected function _totalBaseCalculation(Mage_Sales_Model_Quote_Address $address, $taxRateRequest)
    {
        $items = $this->_getAddressItems($address);
        $store = $address->getQuote()->getStore();
        $taxGroups = array();
        $itemTaxGroups = array();
        $catalogPriceInclTax = $this->_config->priceIncludesTax($store);

        foreach ($items as $item) {
            if ($item->getParentItem()) {
                continue;
            }

            if ($item->getHasChildren() && $item->isChildrenCalculated()) {
                foreach ($item->getChildren() as $child) {
                	$taxRateRequest->setIsVirtual($child->getProduct()->getIsVirtual());
                	
                    $this->_totalBaseProcessItemTax(
                        $child, $taxRateRequest, $taxGroups, $itemTaxGroups, $catalogPriceInclTax);
                }
                $this->_recalculateParent($item);
            } else {
            	$taxRateRequest->setIsVirtual($item->getProduct()->getIsVirtual());
            	
                $this->_totalBaseProcessItemTax(
                    $item, $taxRateRequest, $taxGroups, $itemTaxGroups, $catalogPriceInclTax);
            }
        }

        if ($address->getQuote()->getTaxesForItems()) {
            $itemTaxGroups += $address->getQuote()->getTaxesForItems();
        }
        $address->getQuote()->setTaxesForItems($itemTaxGroups);

        foreach ($taxGroups as $taxId => $data) {
            if ($catalogPriceInclTax) {
                $rate = (float)$taxId;
            } else {
                $rate = $data['applied_rates'][0]['percent'];
            }

            $inclTax = $data['incl_tax'];

            $totalTax = array_sum($data['tax']);
            $baseTotalTax = array_sum($data['base_tax']);
            $this->_addAmount($totalTax);
            $this->_addBaseAmount($baseTotalTax);
            $totalTaxRounded = $this->_calculator->round($totalTax);
            $baseTotalTaxRounded = $this->_calculator->round($totalTaxRounded);
            $this->_saveAppliedTaxes($address, $data['applied_rates'], $totalTaxRounded, $baseTotalTaxRounded, $rate);
        }
        return $this;
    }
    
    /**
     * Collect applied tax rates information on address level
     *
     * @param   Mage_Sales_Model_Quote_Address $address
     * @param   array $applied
     * @param   float $amount
     * @param   float $baseAmount
     * @param   float $rate
     */
    protected function _saveAppliedTaxes(Mage_Sales_Model_Quote_Address $address,
    		$applied, $amount, $baseAmount, $rate)
    {
    	$previouslyAppliedTaxes = $address->getAppliedTaxes();
    	$process = count($previouslyAppliedTaxes);
    
    	foreach ($applied as $row) {
    		if ($row['percent'] == 0) {
    			//continue;
    		}
    		if (!isset($previouslyAppliedTaxes[$row['id']])) {
    			$row['process'] = $process;
    			$row['amount'] = 0;
    			$row['base_amount'] = 0;
    			$previouslyAppliedTaxes[$row['id']] = $row;
    		} else {
            	foreach ($row['rates'] as $_rate) {
            		foreach ($previouslyAppliedTaxes[$row['id']]['rates'] as $_prevRate) {
            			if ($_prevRate['rule_id'] == $_rate['rule_id']) {
            				continue 2;
            			}
            		}
            		$previouslyAppliedTaxes[$row['id']]['rates'][] = $_rate;
            	}
            }
    
    		if (!is_null($row['percent'])) {
    			$row['percent'] = $row['percent'] ? $row['percent'] : 1;
    			$rate = $rate ? $rate : 1;
    
    			$appliedAmount = $amount / $rate * $row['percent'];
    			$baseAppliedAmount = $baseAmount / $rate * $row['percent'];
    		} else {
    			$appliedAmount = 0;
    			$baseAppliedAmount = 0;
    			foreach ($row['rates'] as $rate) {
    				$appliedAmount += $rate['amount'];
    				$baseAppliedAmount += $rate['base_amount'];
    			}
    		}
    
    
    		if ($appliedAmount >= 0 || $previouslyAppliedTaxes[$row['id']]['amount'] >= 0) {
    			$previouslyAppliedTaxes[$row['id']]['amount'] += $appliedAmount;
    			$previouslyAppliedTaxes[$row['id']]['base_amount'] += $baseAppliedAmount;
    		} else {
    			unset($previouslyAppliedTaxes[$row['id']]);
    		}
    	}
    	$address->setAppliedTaxes($previouslyAppliedTaxes);
    }
}