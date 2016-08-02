<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2016 B3 IT Systeme GmbH (http://www.b3-it.de)
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Model_Tax_Calculation_Rule extends Mage_Tax_Model_Calculation_Rule
{
	/**
	 * Fetches rules by rate, customer tax class and product tax class
	 * and product tax class combination
	 *
	 * @param array   $rateId
	 * @param array   $customerTaxClassId
	 * @param array   $productTaxClassId
	 * @param boolean $validTaxvat
	 * 
	 * @return array
	 */
	public function fetchRuleCodesValidTaxvat($rateId, $customerTaxClassId, $productTaxClassId, $validTaxvat)
	{
		return $this->getResource()->fetchRuleCodesValidTaxvat($rateId, $customerTaxClassId, $productTaxClassId, $validTaxvat);
	}
}