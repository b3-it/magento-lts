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

		$salesRuleCollection->addFieldToFilter('website_ids', array('finset' => (int)$websiteId))
            ->addFieldToFilter('customer_group_ids', array('finset' => (int)$customerGroupId))
            ->addFieldToFilter('coupon_type', Mage_SalesRule_Model_Rule::COUPON_TYPE_SPECIFIC)
            ->addFieldToFilter('is_active', 1);

		$now = Mage::getModel('core/date')->date('Y-m-d');
		$filterIsNull = array('null' => true);
		$filterlteq = array('from' => $now);
		$filtergteq = array('to'=> $now);

		$salesRuleCollection->addFieldToFilter('from_date', array($filterIsNull,$filtergteq ))
			->addFieldToFilter('to_date', array($filterIsNull, $filterlteq));

		//$debug = $salesRuleCollection->getSelectCountSql()->assemble();
		//die($debug);
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
