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
	/**
	 * Store associated with rule entities information map
	 *
	 * @var array
	 * @see Mage_SalesRule_Model_Resource_Rule_Collection
	 */
	protected $_associatedEntitiesMap = array(
			'website' => array(
					'associations_table' => 'salesrule/website',
					'rule_id_field'      => 'rule_id',
					'entity_id_field'    => 'website_id'
			),
			'customer_group' => array(
					'associations_table' => 'salesrule/customer_group',
					'rule_id_field'      => 'rule_id',
					'entity_id_field'    => 'customer_group_id'
			)
	);
	
	/**
	 * Retrieve correspondent entity information (associations table name, columns names)
	 * of rule's associated entity by specified entity type
	 *
	 * @param string $entityType
	 *
	 * @return array
	 */
	protected function _getAssociatedEntityInfo($entityType)
	{
		if (isset($this->_associatedEntitiesMap[$entityType])) {
			return $this->_associatedEntitiesMap[$entityType];
		}
	
		$e = Mage::exception(
				'Mage_Core',
				Mage::helper('rule')->__('There is no information about associated entity type "%s".', $entityType)
				);
		throw $e;
	}

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
		
		$salesRuleCollection->addWebsiteFilter(intval($websiteId));
        
        $now = Mage::getModel('core/date')->date('Y-m-d');
        
        $entityInfo = $this->_getAssociatedEntityInfo('customer_group');
        $connection = $salesRuleCollection->getConnection();
        $salesRuleCollection->getSelect()
        	->joinInner(
        			array('customer_group_ids' => $salesRuleCollection->getTable($entityInfo['associations_table'])),
        			$connection->quoteInto(
        				'main_table.' . $entityInfo['rule_id_field']
        				. ' = customer_group_ids.' . $entityInfo['rule_id_field']
        				. ' AND customer_group_ids.' . $entityInfo['entity_id_field'] . ' = ?',
        				(int)$customerGroupId
        				),
        			array()
        		)
        	//sind die nicht falsch herum --> CORE-BUG? @see addWebsiteGroupDateFilter
//         	->where('from_date is null or from_date <= ?', $now)
//         	->where('to_date is null or to_date >= ?', $now)
        ;
        
        $salesRuleCollection->addIsActiveFilter();

		$filterIsNull = array('null' => true);
		$filterlteq = array('from' => $now);
		$filtergteq = array('to'=> $now);

		$salesRuleCollection->addFieldToFilter('from_date', array($filterIsNull,$filtergteq ))
			->addFieldToFilter('to_date', array($filterIsNull, $filterlteq));

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
