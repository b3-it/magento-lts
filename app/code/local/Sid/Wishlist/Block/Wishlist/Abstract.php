<?php
/**
 * Abstrakter Block für Merkzettel
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Sid_Wishlist_Block_Wishlist_Abstract extends Mage_Core_Block_Template
{
	protected $_quotes = null;
	protected $_quote = null;
	
	/**
	 * Prüft ob der Kunde eingeloggt ist
	 *
	 * @return bool
	 */
	public function isCustomerLoggedIn() {
		return Mage::getSingleton('customer/session')->isLoggedIn();
	}
	
	/**
	 * Liefert alle Wunschlisten des aktuellen Kunden
	 * 
	 * Es werden auch die gemeinsam genutzten Merklisten angezeigt
	 * 
	 * @return Sid_Wishlist_Model_Resource_Quote_Collection
	 */
	public function getWishlists() {
		if (!is_null($this->_quotes)) {
			return $this->_quotes;
		}
	
		/* @var $quoteCollection Sid_Wishlist_Model_Resource_Quote_Collection */
		$quoteCollection = Mage::getModel('sidwishlist/quote')->getCollection();
		$customerId = Mage::getSingleton('customer/session')->getCustomerId();
	
		if (!is_numeric($customerId) || $customerId < 1) {
			$this->_quotes = null;
			return null;
		}
			
		$quoteCollection->addFieldToFilter('customer_acls', array('like' => "%i:$customerId;%"));
		$this->_quotes = $quoteCollection;
		
		return $this->_quotes;
	}
	
	/**
	 * Liefert eine Merkzettel-Instanz zurück
	 * 
	 * @return Sid_Wishlist_Model_Quote|null
	 */
	public function getWishlist() {
		if (!is_null($this->_quote)) {
			return $this->_quote;
		}
	
		$customerId = Mage::getSingleton('customer/session')->getCustomerId();
	
		if (!is_numeric($customerId) || $customerId < 1) {
			$this->_quote = null;
			return null;
		}
		
		$data = Mage::getSingleton('sidwishlist/session')->getWishlistPostData();
		/* @var $quote Sid_Wishlist_Model_Quote */
		$quote = Mage::getModel('sidwishlist/quote', is_array($data) ? $data : array());
		
		$quote->assignCustomer(Mage::getSingleton('customer/session')->getCustomer());
				
		$this->_quote = $quote;
		
		return $this->_quote;
	}
	
	/**
	 * Prüft ob es schon Merkzettel gibt
	 *
	 * @return bool
	 */
	public function customerHasWishlists() {
		$customerId = Mage::getSingleton('customer/session')->getCustomerId();			
	
		if ($this->getWishlists()->getSize() < 1) {
			return false;
		}
	
		return true;
	}
	
	/**
	 * Liefert die Session für Merklisten
	 * 
	 * @return Sid_Wishlist_Model_Session
	 */
	public function getSession() {
		return Mage::getSingleton('sidwishlist/session');
	}
}