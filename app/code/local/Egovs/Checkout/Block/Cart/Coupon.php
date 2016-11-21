<?php
/**
 * Formular zur Anzeige und Eingabe für Coupon-Codes
 *
 * @category	Egovs
 * @package		Egovs_Checkout
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2016 B3 IT Systeme GmbH <www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Checkout_Block_Cart_Coupon extends Mage_Checkout_Block_Cart_Coupon
{
	protected function _isCouponRuleAvaillable($websiteId = null, $customerGroupId = null) {
		if (is_null($websiteId)) {
			$websiteId = $this->getQuote()->getStore()->getWebsiteId();
		}

		if (is_null($customerGroupId)) {
			$customerGroupId = $this->getQuote()->getCustomerGroupId();
		}

		/* @var $salesRuleCollection Mage_SalesRule_Model_Resource_Rule_Collection */
		$salesRuleCollection = Mage::getModel('salesrule/rule')->getCollection();
		//Join entfernen
		$salesRuleCollection->getSelect()->reset();
		//reinit
		$salesRuleCollection->getSelect()->from(array('main_table' => $salesRuleCollection->getMainTable()));

		$salesRuleCollection->addFieldToFilter('coupon_type', Mage_SalesRule_Model_Rule::COUPON_TYPE_SPECIFIC);
		
		$salesRuleCollection->addWebsiteGroupDateFilter(intval($websiteId), $customerGroupId);
		
		if (Mage::getStoreConfig('dev/log/log_level') == Zend_Log::DEBUG) {
			$debug = $salesRuleCollection->getSelectCountSql()->assemble();
			Mage::log("Coupon SalesRuleSql::\n$debug", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		}
		if ($salesRuleCollection->getSize() > 0) {
			return true;
		}

		return false;
	}

	/**
     * Render block HTML
     *
     * @return string
     */
    protected function _toHtml() {

    	if (!$this->_isCouponRuleAvaillable()) {
    		return '';
    	}

        return parent::_toHtml();
    }
}
