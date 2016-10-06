<?php
/**
 * Sales Observer
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Sid_Wishlist_Model_Sales_Observer
{
	protected $_lastItemId = null;
	
	public function onSalesOrderPlaceAfter($observer) {
		/** @var $_order Mage_Sales_Model_Order */
		$_order = $observer->getOrder();
		
		foreach ($_order->getItemsCollection() as $orderItem) {
			/** @var $orderItem Mage_Sales_Model_Order_Item */
			$qtyOrdered = $orderItem->getQtyOrdered();
			$_wishlistItem = Mage::getModel('sidwishlist/quote_item')->load($orderItem->getSidwishlistItemId());
			if (!$_wishlistItem->getId()) {
				continue;
			}
			
			$_wishlistItem->setQtyOrdered($qtyOrdered);
		}
		
		$_order->getItemsCollection()->save();
	}
	
	public function onSalesQuoteAddItem($observer) {
		/** @var $_quoteItem Mage_Sales_Model_Quote_Item */
		$_quoteItem = $observer->getQuoteItem();
		$_buyRequest = $_quoteItem->getBuyRequest();
		
		if (!$_buyRequest || $_buyRequest->isEmpty()) {
			return;
		}
		
		if (!$_buyRequest->hasSidwishlistItemId()) {
			return;
		}
		
		$_quoteItem->setSidwishlistItemId($_buyRequest->getSidwishlistItemId())
			->save();
	}
	
	public function onQuoteItemRemove($observer) {
		/** @var $salesQuoteItem Mage_Sales_Model_Quote_Item */
		$salesQuoteItem = $observer->getItem();
	
		if (!$salesQuoteItem || $salesQuoteItem->getId() == $this->_lastItemId) {
			return;
		}
	
		if (!$salesQuoteItem->getSidwishlistItemId()) {
			return;
		}
		
		$_sidWishlistItem = Mage::getModel('sidwishlist/quote_item')->load($salesQuoteItem->getSidwishlistItemId());
		
		if ($_sidWishlistItem->isEmpty()) {
			return;
		}
		
		$_sidWishlistItem->setQtyGranted(0)
			->setStatus(Sid_Wishlist_Model_Quote_Item_Abstract::STATUS_EDITABLE)
			->save();
	
		$this->_lastItemId = $salesQuoteItem->getId();
	}
	
	public function onSalesQuoteItemQtySetAfter($observer) {
		/** @var $salesQuoteItem Mage_Sales_Model_Quote_Item */
		$salesQuoteItem = $observer->getItem();
		
		if (!$salesQuoteItem) {
			return;
		}
		
		if (!$salesQuoteItem->getSidwishlistItemId()) {
			return;
		}
		
		$_sidWishlistItem = Mage::getModel('sidwishlist/quote_item')->load($salesQuoteItem->getSidwishlistItemId());
		
		if ($_sidWishlistItem->isEmpty()) {
			return;
		}
		
		if ($salesQuoteItem->getOrigData('qty') <= $salesQuoteItem->getData('qty')) {
			return;
		}
		
		$_diffQty = max($salesQuoteItem->getOrigData('qty') - $salesQuoteItem->getData('qty'), 0);
		
		$_sidWishlistItem->setQtyGranted(max($_sidWishlistItem->getQtyGranted() - $_diffQty, 0));
		if ($_sidWishlistItem->getStatus() == Sid_Wishlist_Model_Quote_Item_Abstract::STATUS_ACCEPTED) {
			$_sidWishlistItem->setStatus(Sid_Wishlist_Model_Quote_Item_Abstract::STATUS_BACKORDER);
		}
		$_sidWishlistItem->save();
	}
}