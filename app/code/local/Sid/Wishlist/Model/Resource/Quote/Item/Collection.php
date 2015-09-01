<?php
/**
 * Quote Item - Collection Model
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Resource_Quote_Item_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	/**
	 * Produkt IDs array
	 *
	 * @var array
	 */
	protected $_productIds   = array();

	/**
	 * Collection Quote Instanz
	 *
	 * @var Sid_Wishlist_Model_Quote
	 */
	protected $_quote;
	
	/**
	 * Collection Sales Quote Instanz
	 *
	 * @var Mage_Sales_Model_Quote
	 */
	protected $_salesQuote;

	/**
	 * Initialisiert Resource-Mmodel
	 * 
	 * @return void
	 */
	protected function _construct() {
		$this->_init('sidwishlist/quote_item');
	}

	/**
	 * Ruft Store ID (Von Quote) ab
	 *
	 * @return int
	 */
	public function getStoreId() {
		return (int)$this->_quote->getStoreId();
	}

	/**
	 * Setzt Quote-Object zu Collection
	 *
	 * @param Sid_Wishlist_Model_Quote $quote Quote
	 * 
	 * @return Sid_Wishlist_Model_Resource_Quote_Item_Collection
	 */
	public function setQuote($quote)
	{
		$this->_quote = $quote;
		$quoteId      = $quote->getId();
		$salesQuoteId = $quote->getQuoteEntityId();
		if ($quoteId) {
			$this->addFieldToFilter('quote_id', $quote->getId());
			if ($salesQuoteId && !$this->_salesQuote) {
				$this->_salesQuote = Mage::getModel('sales/quote')->load($salesQuoteId);
				
				if ($this->_salesQuote->isEmpty()) {
					Mage::throwException(Mage::helper('sidwishlist')->__('Error while loading data'));
				}
				/*
				 * If current currency code of quote is not equal current currency code of store,
				* need recalculate totals of quote. It is possible if customer use currency switcher or
				* store switcher.
				*/
				if ($this->_salesQuote->getQuoteCurrencyCode() != Mage::app()->getStore()->getCurrentCurrencyCode()) {
					$this->_salesQuote->setStore(Mage::app()->getStore());
					$this->_salesQuote->collectTotals()->save();
					/*
					 * We mast to create new quote object, because collectTotals()
					* can to create links with other objects.
					*/
					$this->_salesQuote = Mage::getModel('sales/quote')->setStoreId(Mage::app()->getStore()->getId());
					$this->_salesQuote->load($this->getQuoteEntityId());
				}
			}
		} else {
			$this->_totalRecords = 0;
			$this->_setIsLoaded(true);
		}
		return $this;
	}
	
	/**
	 * Setzt die Magento Sales Quote
	 * 
	 * @param Mage_Sales_Model_Quote $salesQuote
	 * 
	 * @return Sid_Wishlist_Model_Resource_Quote_Item_Collection
	 */
	public function setSalesQuote($salesQuote) {
		$this->_salesQuote = $salesQuote;
		
		return $this;
	}

	/**
	 * Macht einen Reset der collection und führt einen Inner-Join zur Quotes-Tabelle durch
	 * 
	 * Optional:<br>
	 * Selektiert nur Produkte mit der enstprechnender Produkt-ID
	 *
	 * @param string $quotesTableName Quote-Tabellen-Name
	 * @param int    $productId       Produkt ID 
	 * 
	 * @return Sid_Wishlist_Model_Resource_Quote_Item_Collection
	 */
	public function resetJoinQuotes($quotesTableName, $productId = null) {
		$this->getSelect()->reset()
			->from(
				array('qi' => $this->getResource()->getMainTable()),
				array('item_id', 'qty_requested', 'qty_granted', 'quote_id')
			)->joinInner(
				array('q' => $quotesTableName),
				'qi.quote_id = q.entity_id',
				array('store_id', 'items_qty', 'items_count')
			)
		;
		if ($productId) {
			$this->getSelect()
				->joinInner(
						array('msqi' => 'sales/quote_item'),
						'qi.quote_item_id = msqi.item_id',
						array('product_id')
				)->where('msqi.product_id = ?', (int)$productId);
		}
		return $this;
	}

	/**
	 * Verarbeitung nach dem Laden
	 *
	 * @return Sid_Wishlist_Model_Resource_Quote_Item_Collection
	 */
	protected function _afterLoad()
	{
		parent::_afterLoad();

		/**
		 * Assign parent items
		 */
		foreach ($this as $item) {
			/* @var $item Sid_Wishlist_Model_Quote_Item */
			if ($item->getParentItemId()) {
				$item->setParentItem($this->getItemById($item->getParentItemId()));
			}
			if ($this->_quote) {
				$item->setQuote($this->_quote);
			}
			if ($this->_salesQuote) {
				if ($item->hasQuoteItemId()) {
					$item->setSalesQuoteItem($this->_salesQuote->getItemById($item->getQuoteItemId()));
				}
			}
		}

		/**
		 * Assign options and products
		 */
		$this->_assignOptions();
// 		$this->_assignProducts();
		$this->resetItemsDataChanged();

		return $this;
	}

	/**
	 * Fügt options zu den Items hinzu
	 *
	 * @return Sid_Wishlist_Model_Resource_Quote_Item_Collection
	 */
	protected function _assignOptions()
	{
		$itemIds          = array_keys($this->_items);
		$optionCollection = Mage::getModel('sidwishlist/quote_item_option')->getCollection()
			->addItemFilter($itemIds)
		;
		
		foreach ($this as $item) {
			$item->setOptions($optionCollection->getOptionsByItem($item));
		}
		$productIds        = $optionCollection->getProductIds();
		$this->_productIds = array_merge($this->_productIds, $productIds);

		return $this;
	}

	/**
	 * Fügt Produkte zu Items und Item-Options hinzu
	 *
	 * @return Sid_Wishlist_Model_Resource_Quote_Item_Collection
	 */
	protected function _assignProducts()
	{
		Varien_Profiler::start('SID QUOTE:'.__METHOD__);
		$productIds = array();
		foreach ($this as $item) {
			$productIds[] = (int)$item->getProductId();
		}
		$this->_productIds = array_merge($this->_productIds, $productIds);

		//TODO implement me
		
		Varien_Profiler::stop('SID QUOTE:'.__METHOD__);

		return $this;
	}
}

