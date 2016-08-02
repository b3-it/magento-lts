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
class Egovs_GermanTax_Model_Resource_Tax_Calculation_Rule extends Mage_Tax_Model_Resource_Calculation_Rule
{
	/**
     * Fetches rules by rate, customer tax class and product tax class
     * Returns array of rule codes
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
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()
            ->from(array('main' => $this->getTable('tax/tax_calculation')), null)
            ->joinLeft(
	            array('d' => $this->getTable('tax/tax_calculation_rule')),
	            'd.tax_calculation_rule_id = main.tax_calculation_rule_id',
	            array('d.code')
            )
            ->where('main.tax_calculation_rate_id in (?)', $rateId)
            ->where('main.customer_tax_class_id in (?)', $customerTaxClassId)
            ->where('main.product_tax_class_id in (?)', $productTaxClassId)
            ->where('d.valid_taxvat in (?)', $validTaxvat)
            ->distinct(true);

        return $adapter->fetchCol($select);
    }
}