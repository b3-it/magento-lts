<?php

class Stala_Extcustomer_Helper_Data extends Mage_Core_Helper_Abstract
{
	const FREECOPIES_FIELD = "freecopies_count";
	const OPTION_GLOBAL = 0;
	const OPTION_INDIVIDUAL = 1;
	const OPTION_DERIVATE = 2;
	
	/**
	 * Calculates the real tax amount without any discount
	 *
	 * @param Mage_Sales_Model_Quote_Item $quoteItem
	 *
	 * @see Mage_Sales_Model_Quote_Item_Abstract::calcTaxAmount
	 */
	public function getCalcTaxAmount($quoteItem) {
		/* @var $quoteItem Mage_Sales_Model_Quote_Item */
		$rowTotal = $quoteItem->getRowTotal();
		$taxPercent = $quoteItem->getTaxPercent() / 100;
	
		$qty = $quoteItem->getQty();
	
		if ($quoteItem->getParentItem()) {
			$qty = $qty*$quoteItem->getParentItem()->getQty();
		}
	
		$pricevector = $quoteItem->getPricevector();
		$store = $quoteItem->getStore();
		$TaxAmount = 0.0;
	
		if(($pricevector != null) && (is_array($pricevector)))
		{
			$sum = array_sum($pricevector) * $qty;
			if(abs($sum - $rowTotal)< 0.1 ){
				foreach($pricevector as $price){
					$TaxAmount += $store->roundPrice(($price * $taxPercent)) * $qty;
				}
			}else{
				$TaxAmount = $store->roundPrice(($rowTotal /$qty * $taxPercent)) * $qty;
			}
		}else {
			$TaxAmount = $store->roundPrice(($rowTotal /$qty * $taxPercent)) * $qty;
		}
	
		return $TaxAmount;
	}
	
	/**
	 * Calculates the real base tax amount without any discount
	 *
	 * @param Mage_Sales_Model_Quote_Item $quoteItem
	 *
	 * @see Mage_Sales_Model_Quote_Item_Abstract::calcTaxAmount
	 */
	public function getCalcBaseTaxAmount($quoteItem) {
		/* @var $quoteItem Mage_Sales_Model_Quote_Item */
		$rowBaseTotal = $quoteItem->getRowBaseTotal();
		$taxPercent = $quoteItem->getTaxPercent() / 100;
	
		$qty = $quoteItem->getQty();
	
		if ($quoteItem->getParentItem()) {
			$qty = $qty*$quoteItem->getParentItem()->getQty();
		}
	
		$pricevector = $quoteItem->getPricevector();
		$store = $quoteItem->getStore();
		$BaseTaxAmount = 0.0;
	
		if(($pricevector != null) && (is_array($pricevector)))
		{
			$sum = array_sum($pricevector) * $qty;
			if(abs($sum - $rowBaseTotal)< 0.1 ){
				foreach($pricevector as $price){
					$BaseTaxAmount += $store->roundPrice(($price * $taxPercent)) * $qty;
				}
			}else{
				$BaseTaxAmount = $store->roundPrice(($rowBaseTotal /$qty * $taxPercent)) * $qty;
			}
		}else {
			$BaseTaxAmount = $store->roundPrice(($rowBaseTotal / $qty * $taxPercent)) * $qty;
		}
	
		return $BaseTaxAmount;
	}
	
	/*
	 * source: Magento 1.5.1 Mage_Core_Helper_Data
	 */
	######################################################################################################
	/**
     * Encode the mixed $valueToEncode into the JSON format
     *
     * @param mixed $valueToEncode
     * @param  boolean $cycleCheck Optional; whether or not to check for object recursion; off by default
     * @param  array $options Additional options used during encoding
     * @return string
     */
    public function jsonEncode($valueToEncode, $cycleCheck = false, $options = array())
    {
        $json = Zend_Json::encode($valueToEncode, $cycleCheck, $options);
        /* @var $inline Mage_Core_Model_Translate_Inline */
        $inline = Mage::getSingleton('core/translate_inline');
        if ($inline->isAllowed()) {
            $inline->setIsJson(true);
            $inline->processResponseBody($json);
            $inline->setIsJson(false);
        }

        return $json;
    }

    /**
     * Decodes the given $encodedValue string which is
     * encoded in the JSON format
     *
     * @param string $encodedValue
     * @return mixed
     */
    public function jsonDecode($encodedValue, $objectDecodeType = Zend_Json::TYPE_ARRAY)
    {
        return Zend_Json::decode($encodedValue, $objectDecodeType);
    }
    ######################################################################################################
}