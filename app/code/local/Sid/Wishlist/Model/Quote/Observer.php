<?php
/**
 * Wishlist Observer-Model
 *
 * Führt für registrierte Events definierte Funktionen aus
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Quote_Observer extends Mage_Core_Model_Abstract
{
	protected $_lastItemId = null;
	
	/**
	 * Expire quotes additional fields to filter
	 *
	 * @var array
	 */
	protected $_expireQuotesFilterFields = array();
	
	public function onQuoteItemRemove($observer) {
		$salesQuoteItem = $observer->getItem();
		
		if (!$salesQuoteItem || $salesQuoteItem->getId() == $this->_lastItemId) {
			return;
		}
		
		/* @var $collection Sid_Wishlist_Model_Resource_Quote_Collection */
		$collection = Mage::getResourceModel('sidwishlist/quote_item_collection');
		$collection->addFieldToSelect('item_id')
			->addFieldToSelect('quote_id')
			->addFieldToFilter('quote_item_id', $salesQuoteItem->getId())
		;
		
		foreach ($collection->getItems() as $item) {
			//Quote/Merkliste darf hier nicht geladen werden, da sonst Endlosschleife entsteht!!
			$note = Mage::helper('sidwishlist')->__(
			    "Product '%s' with quantity %d is no more saleable and was automatically removed",
                $salesQuoteItem->getName(),
                $salesQuoteItem->getQty()
            );
			Mage::getSingleton('sidwishlist/session')->addNotice($note);
			Mage::getSingleton('sidwishlist/session')->setTriggerRecollect(true);
			$salesQuoteItem->getQuote()->setTriggerRecollect(1)->save();
		}
		
		$this->_lastItemId = $salesQuoteItem->getId();
	}
	
	/**
	 * Retrieve expire quotes additional fields to filter
	 *
	 * @return array
	 */
	public function getExpireQuotesAdditionalFilterFields() {
		return $this->_expireQuotesFilterFields;
	}
	
	/**
	 * Set expire quotes additional fields to filter
	 *
	 * @param array $fields Feld mit Filterbedingung
	 * 
	 * @return Sid_Wishlist_Model_Quote_Observer
	 */
	public function setExpireQuotesAdditionalFilterFields(array $fields) {
		$this->_expireQuotesFilterFields = $fields;
		return $this;
	}
	
	/**
	 * Löscht veraltete Merklisten (cron process)
	 *
	 * @param Mage_Cron_Model_Schedule $schedule Zeiplan
	 * 
	 * @return Sid_Wishlist_Model_Quote_Observer
	 */
	public function cleanExpiredQuotes($schedule) {
		Mage::dispatchEvent('clear_expired_sid_collector_lists_before', array('quote_observer' => $this));
	
		$lifetimes = Mage::getConfig()->getStoresConfigByPath('sidwishlist/general/delete_quote_after');
		foreach ($lifetimes as $storeId=>$lifetime) {
            /** @noinspection SummerTimeUnsafeTimeManipulationInspection */
			$lifetime *= 86400;
	
			/* @var $quotes Sid_Wishlist_Model_Resource_Quote_Collection */
			$quotes = Mage::getModel('sidwishlist/quote')->getCollection();
	
			$quotes->addFieldToFilter('store_id', $storeId);
			$quotes->addFieldToFilter('updated_at', array('to'=>date("Y-m-d H:i:s", time()-$lifetime)));
// 			$quotes->addFieldToFilter('is_active', 0);
	
			foreach ($this->getExpireQuotesAdditionalFilterFields() as $field => $condition) {
				$quotes->addFieldToFilter($field, $condition);
			}
	
			Mage::log("sidwishlist::Clean expired collector lists for store $storeId", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			$quotes->walk('delete');
		}
		return $this;
	}
}