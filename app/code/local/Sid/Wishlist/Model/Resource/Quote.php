<?php
/**
 * Quote Resource-Model
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Resource_Quote extends Sid_Wishlist_Model_Resource_Abstract
{
	const ENTITY_ID = 'entity_id';
	const SHARING_CODE = 'sharing_code';
	
	/**
	 * Konstruktor -
	 *
	 * @return void
	 *
	 * @see Mage_Core_Model_Resource_Abstract::_construct()
	 */
	protected function _construct() {
		// Note that the sidwishlist_quote_id refers to the key field in your database table.
		$this->_init('sidwishlist/quote', self::ENTITY_ID);
	}
	
// 	/**
// 	 * Initialize unique fields
// 	 *
// 	 * @return Mage_Core_Model_Resource_Db_Abstract
// 	 */
	/* protected function _initUniqueFields() {
		$this->_uniqueFields = array(
			array(
				'field' => array('name'),
				//An den Titel wird ' exisitiert bereits' später noch angehängt!!
				'title' => Mage::helper('sidwishlist')->__('This name'),
			),
		);
		return $this;
	} */

	/**
	 * Ruft Select-Oobject zum laden der Ojekt-Daten ab
	 *
	 * @param string                   $field  Field
	 * @param mixed                    $value  Values
	 * @param Mage_Core_Model_Abstract $object Object
	 * 
	 * @return Varien_Db_Select
	 */
	protected function _getLoadSelect($field, $value, $object)
	{
		$select   = parent::_getLoadSelect($field, $value, $object);
		$storeIds = $object->getSharedStoreIds();
		if ($storeIds) {
			$select->where('store_id IN (?)', $storeIds);
		} else {
			/**
			 * For empty result
			 */
			$select->where('store_id < ?', 0);
		}

		return $select;
	}

	/**
	 * Lädt Quote-Daten der default Quote anhand der Kunden-ID
	 *
	 * @param Sid_Wishlist_Model_Resource_Quote $quote      Quote
	 * @param int                               $customerId Kunden ID
	 * 
	 * @return Sid_Wishlist_Model_Resource_Quote
	 */
	public function loadByCustomerId($quote, $customerId)
	{
		$adapter = $this->_getReadAdapter();
		$select  = $this->_getLoadSelect('customer_id', $customerId, $quote)
			->where('is_active = ?', 1)
			->where('is_default = ?', 1)
			->order('updated_at ' . Varien_Db_Select::SQL_DESC)
			->limit(1);

		$data    = $adapter->fetchRow($select);

		if ($data) {
			$quote->setData($data);
		}

		$this->_afterLoad($quote);

		return $this;
	}

	/**
	 * Lädt nur eine aktive Quote
	 *
	 * @param Sid_Wishlist_Model_Resource_Quote $quote   Quote
	 * @param int                               $quoteId Quote-ID
	 * 
	 * @return Sid_Wishlist_Model_Resource_Quote
	 */
	public function loadActive($quote, $quoteId) {
		$adapter = $this->_getReadAdapter();
		$select  = $this->_getLoadSelect(self::ENTITY_ID, $quoteId, $quote)
			->where('is_active = ?', 1)
		;

		$data    = $adapter->fetchRow($select);
		if ($data) {
			$quote->setData($data);
		}

		$this->_afterLoad($quote);

		return $this;
	}
	
	public function loadByShareCode($quote, $share) {
		$adapter = $this->_getReadAdapter();
		$select  = $this->_getLoadSelect(self::SHARING_CODE, $share, $quote);
	
		$data    = $adapter->fetchRow($select);
		if ($data) {
			$quote->setData($data);
		}
	
		$this->_afterLoad($quote);
	
		return $this;
	}

	/**
	 * Lädt die Quote-Daten per ID ohne Store
	 *
	 * @param Sid_Wishlist_Model_Resource_Quote $quote   Quote
	 * @param int                               $quoteId Quote ID
	 * 
	 * @return Sid_Wishlist_Model_Resource_Quote
	 */
	public function loadByIdWithoutStore($quote, $quoteId)
	{
		$read = $this->_getReadAdapter();
		if ($read) {
			$select = parent::_getLoadSelect(self::ENTITY_ID, $quoteId, $quote);

			$data = $read->fetchRow($select);

			if ($data) {
				$quote->setData($data);
			}
		}

		$this->_afterLoad($quote);
		return $this;
	}

	/**
	 * Subtrahiert Produkt von gesamter Quote-Menge
	 *
	 * @param Mage_Catalog_Model_Product $product Produkt
	 * 
	 * @return Sid_Wishlist_Model_Resource_Quote
	 */
	public function substractProductFromQuotes($product)
	{
		$productId = (int)$product->getId();
		if (!$productId) {
			return $this;
		}
		$adapter   = $this->_getWriteAdapter();
		$subSelect = $adapter->select();

		$subSelect->from(false, array(
				'items_qty'   => new Zend_Db_Expr(
						$adapter->quoteIdentifier('q.items_qty') . ' - ' . $adapter->quoteIdentifier('qi.qty')),
				'items_count' => new Zend_Db_Expr($adapter->quoteIdentifier('q.items_count') . ' - 1')
		))
		->join(
				array('qi' => $this->getTable('sidwishlist/quote_item')),
				implode(' AND ', array(
						'q.entity_id = qi.quote_id',
						'qi.parent_item_id IS NULL',
						$adapter->quoteInto('qi.product_id = ?', $productId)
				)),
				array()
		);

		$updateQuery = $adapter->updateFromSelect($subSelect, array('q' => $this->getTable('sidwishlist/quote')));

		$adapter->query($updateQuery);

		return $this;
	}
}