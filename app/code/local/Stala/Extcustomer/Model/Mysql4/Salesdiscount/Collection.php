<?php

class Stala_Extcustomer_Model_Mysql4_Salesdiscount_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	const QUOTE_ITEM_ID = "sales_quote_item_id";
	const CUSTOMER_ID = "customer_id";
	
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Model_Resource_Db_Collection_Abstract::_construct()
	 */
	protected function _construct() {
		parent::_construct();
		$this->_init('extcustomer/salesdiscount');
	}

	public function load($printQuery = false, $logQuery = false) {		
		return parent::load($printQuery, $logQuery);
	}
	
	/**
	 * Per quote Item ID laden
	 * 
	 * @param int $quoteItemId Quote Item ID
	 * 
	 * @return Stala_Extcustomer_Model_Mysql4_Salesdiscount_Collection
	 */
	public function loadByQuoteItemId($quoteItemId) {
		$this->addFilterByQuoteItemId($quoteItemId);
		$this->load();
		
		return $this;
	}
	
	public function loadByQuoteItemIdAndCustomerId($quoteItemId, $customerId) {
		$this->addFilterByQuoteItemId($quoteItemId);
		$this->addFilterByCustomerId($customerId);
		$this->load();
		
		return $this;
	}
	
	public function addFilterByQuoteItemId($quoteItemId) {
		$this->getSelect()->where(self::QUOTE_ITEM_ID." = ?", $quoteItemId);
		
		return $this;
	}
	
	public function addFilterByCustomerId($customerId) {
		$this->getSelect()->where(self::CUSTOMER_ID." = ?", $customerId);
		
		return $this;
	}
}