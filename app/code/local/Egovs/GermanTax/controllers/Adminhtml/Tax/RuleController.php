<?php
require_once 'Mage/Adminhtml/controllers/Tax/RuleController.php';
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2016 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_GermanTax_Adminhtml_Tax_RuleController extends Mage_Adminhtml_Tax_RuleController
{
	/**
     * Check if this a duplicate rule creation request
     *
     * @param Egovs_GermanTax_Model_Tax_Calculation_Rule $ruleModel
     * @return bool
     */
    protected function _isValidRuleRequest($ruleModel)
    {
        $existingRules = $ruleModel->fetchRuleCodesValidTaxvat($ruleModel->getTaxRate(),
            $ruleModel->getTaxCustomerClass(), $ruleModel->getTaxProductClass(), $ruleModel->getValidTaxvat());

        //Remove the current one from the list
        $existingRules = array_diff($existingRules, array($ruleModel->getCode()));

        //Verify if a Rule already exists. If not throw an error
        if (count($existingRules) > 0) {
            $ruleCodes = implode(",", $existingRules);
            $this->_getSingletonModel('adminhtml/session')->addError(
                $this->_getHelperModel('tax')->__('Rules (%s) already exist for the specified Tax Rate, Customer Tax Class and Product Tax Class combinations', $ruleCodes));
            return false;
        }
        return true;
    }
}
