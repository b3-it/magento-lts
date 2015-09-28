<?php
class Egovs_GermanTax_Model_Tax_Sales_Total_Quote_Subtotal extends Mage_Tax_Model_Sales_Total_Quote_Subtotal
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
	 * Caclulate item price and row total with configured rounding level
	 *
	 * @param Mage_Sales_Model_Quote_Address $address
	 * @param Mage_Sales_Model_Quote_Item_Abstract $item
	 * @return Mage_Tax_Model_Sales_Total_Quote_Subtotal
	 */
	protected function _processItem($item, $taxRequest)
	{
		$taxRequest->setIsVirtual($item->getIsVirtual());
		 
		switch ($this->_config->getAlgorithm($this->_store)) {
			case Mage_Tax_Model_Calculation::CALC_UNIT_BASE:
				$this->_unitBaseCalculation($item, $taxRequest);
				break;
			case Mage_Tax_Model_Calculation::CALC_ROW_BASE:
				$this->_rowBaseCalculation($item, $taxRequest);
				break;
			case Mage_Tax_Model_Calculation::CALC_TOTAL_BASE:
				$this->_totalBaseCalculation($item, $taxRequest);
				break;
			default:
				break;
		}
		return $this;
	}
	
	/**
	 * Add row total item amount to subtotal
	 *
	 * @param   Mage_Sales_Model_Quote_Address $address
	 * @param   Mage_Sales_Model_Quote_Item_Abstract $item
	 * @return  Mage_Tax_Model_Sales_Total_Quote_Subtotal
	 */
	protected function _addSubtotalAmount(Mage_Sales_Model_Quote_Address $address, $item)
	{
		
		if ($this->_config->priceIncludesTax($this->_store)) {
			$subTotal = $item->getRowTotalInclTax() - $item->getRowTax();
			$baseSubTotal = $item->getBaseRowTotalInclTax() - $item->getBaseRowTax();
			$address->setTotalAmount('subtotal', $address->getTotalAmount('subtotal') + $subTotal);
			$address->setBaseTotalAmount('subtotal', $address->getBaseTotalAmount('subtotal') + $baseSubTotal);
		} else {
			$address->setTotalAmount('subtotal',
					$address->getTotalAmount('subtotal') + $item->getRowTotal()
			);
			$address->setBaseTotalAmount('subtotal',
					$address->getBaseTotalAmount('subtotal') + $item->getBaseRowTotal());
		}
			
		$address->setSubtotalInclTax($address->getSubtotalInclTax()+$item->getStore()->roundPrice($item->getRowTotalInclTax()));
		$address->setBaseSubtotalInclTax($address->getBaseSubtotalInclTax()+$item->getStore()->roundPrice($item->getBaseRowTotalInclTax()));
		return $this;
	}
}