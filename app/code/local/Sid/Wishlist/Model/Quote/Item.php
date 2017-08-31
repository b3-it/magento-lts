<?php
/**
 * Merkzettel - Item - Model
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Quote_Item extends Sid_Wishlist_Model_Quote_Item_Abstract
{
	protected $_eventPrefix = 'sid_wishlist_quote_item';
	
	const EXCEPTION_CODE_NOT_SALABLE            = 901;
	const EXCEPTION_CODE_HAS_REQUIRED_OPTIONS   = 902;
	const EXCEPTION_CODE_IS_GROUPED_PRODUCT     = 903; // deprecated after 1.4.2.0, because we can store product configuration and add grouped products
	
	
	/**
	 * Merkliste
	 * 
	 * @var Sid_Wishlist_Model_Quote
	 */
	protected $_quote = null;
	
	/**
	 * Initialisiert Resource Model
	 *
	 * @return void
	 */
	protected function _construct() {
		$this->_init('sidwishlist/quote_item');
	}
	
	/**
	 * Quote Item für Speichervorgang vorbereiten
	 *
	 * @return Sid_Wishlist_Model_Quote_Item
	 */
	protected function _beforeSave() {
		parent::_beforeSave();
		if ($this->_getSalesQuoteItem()) {
			$this->setIsVirtual($this->_getSalesQuoteItem()->getIsVirtual());
		}
		if ($this->getQuote()) {
			$this->setQuoteId($this->getQuote()->getId());
		}
		
		return $this;
	}
	
	protected function _afterDelete() {
		return parent::_afterDelete();
	}
	
	protected function _afterDeleteCommit() {
		parent::_afterDeleteCommit();
		
		$salesQuote = $this->_getSalesQuoteItem()->getQuote();
		if ($salesQuote) {
			$salesQuote->removeItem($this->_getSalesQuoteItem()->getId());
		}	
		
		$this->isDeleted(true);
		
		return $this;
	}
	
	/**
	 * Quote Model Object setzen
	 *
	 * @param Sid_Wishlist_Model_Quote $quote Merkliste
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item
	 */
	public function setQuote(Sid_Wishlist_Model_Quote $quote) {
		$this->_quote = $quote;
		//Wichtig wegen __call Funktion
		$this->setData('quote_id', $quote->getId());
		
		return $this;
	}
	
	/**
	 * Retrieve quote model object
	 *
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function getQuote() {
		return $this->_quote;
	}
	
	public function canHaveQty() {
		$product = $this->getProduct();
        return $product->getTypeId() != Mage_Catalog_Model_Product_Type_Grouped::TYPE_CODE;
	}
	
	/**
	 * Per Sales Quote Item Id laden
	 *
	 * @param int $quoteItemId Quote Item ID
	 *
	 * @return Sid_Wishlist_Model_Quote_Item
	 */
	public function loadBySalesQuoteItemId($quoteItemId) {
		$this->_getResource()->loadBySalesQuoteItemId($this, $quoteItemId);
		$this->_afterLoad();
	
		return $this;
	}
	
	/**
	 * Prüft ob dieses Item das entsprechende Sales Quote Item repräsentiert
	 * 
	 * @param int $itemId ID
	 * 
	 * @return bool
	 */
	public function representSalesQuoteItem($itemId) {
		if ($this->getQuoteItemId() < 1 || !is_numeric($itemId)) {
			return false;
		}
		
		if ($this->getQuoteItemId() == $itemId) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Setzt das enstprechende Sales Quote Item für dieses Merkzettel-Item
	 * 
	 * @param Mage_Sales_Model_Quote_Item $salesItem Sales Quote Item
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item
	 */
	public function setSalesQuoteItem($salesItem) {
		if (!($salesItem instanceof Mage_Sales_Model_Quote_Item)) {
			Mage::throwException(Mage::helper('sidwishlist')->__('Mage_Sales_Model_Quote_Item type required!'));
		}
		
		$this->updateItem($salesItem);
		
		if ($salesItem->getHasChildren()) {
			foreach ($salesItem->getChildren() as $child) {
				$item = $this->getQuote()->getItemBySalesQuoteItemId($child->getId());
				if ($item !== false) {
					continue;
				}
				
				//Neues Item erzeugen
				$item = Mage::getModel('sidwishlist/quote_item');
				$item->setQuote($this->getQuote());
				$item->setSalesQuoteItem($child);
				
				$this->addChild($item);
			}
		}
		
		$this->_salesQuoteItem = $salesItem;
		
		return $this;
	}
	
	/**
	 * Löscht das Item
	 * 
	 * Falls es das letzte Item im Merkzettel ist, so wird der Merkzettel NICHT gelöscht!
	 * 
	 * @return Sid_Wishlist_Model_Quote_Item
	 * 
	 * @see Mage_Core_Model_Abstract::delete()
	 */
	public function delete() {
		$this->getQuote()->checkAcl();
		
		$this->_getResource()->beginTransaction();
        try {
            $this->_beforeDelete();
            $this->_getSalesQuoteItem()->delete();
            $this->_getResource()->delete($this);
            $this->_afterDelete();

            $this->_getResource()->commit();
            $this->_afterDeleteCommit();
        }
        catch (Exception $e){
            $this->_getResource()->rollBack();
            throw $e;
        }
        return $this;
	}
	
	/**
	 * Returns formatted buy request - object, holding request received from
	 * product view page with keys and options for configured product
	 *
	 * @return Varien_Object
	 */
	public function getBuyRequest() {
		if ($this->_getSalesQuoteItem()) {
			return $this->_getSalesQuoteItem()->getBuyRequest();
		}
	
		return new Varien_Object();
	}
	
	//Mage_Wishlist
	//#################################################################################################
	/**
	 * Merge data to item info_buyRequest option
	 *
	 * @param array|Varien_Object $buyRequest
	 * @return Mage_Wishlist_Model_Item
	 */
	public function mergeBuyRequest($buyRequest) {
		if ($buyRequest instanceof Varien_Object) {
			$buyRequest = $buyRequest->getData();
		}
	
		if (empty($buyRequest) || !is_array($buyRequest)) {
			return $this;
		}
	
		$oldBuyRequest = $this->getBuyRequest()
			->getData();
		$sBuyRequest = serialize($buyRequest + $oldBuyRequest);
	
		$option = $this->_getSalesQuoteItem()->getOptionByCode('info_buyRequest');
		if ($option) {
			$option->setValue($sBuyRequest);
		} else {
			$this->_getSalesQuoteItem()->addOption(array(
					'code'  => 'info_buyRequest',
					'value' => $sBuyRequest
			));
		}
	
		return $this;
	}
	
	/**
	 * Add or Move item product to shopping cart
	 *
	 * Return true if product was successful added or exception with code
	 * Return false for disabled or unvisible products
	 *
	 * @throws Mage_Core_Exception
	 * @param Mage_Checkout_Model_Cart $cart
	 * @param bool $delete  delete the item after successful add to cart
	 * @return bool
	 */
	public function addToCart(Mage_Checkout_Model_Cart $cart, $buyRequest = null, $delete = false)
	{
		$_product = $this->getProduct();
		$storeId = $this->getStoreId();
		$product = Mage::getModel('catalog/product')
			->setStoreId($_product->getStoreId())
			->load($_product->getId());
	
		
	
		if ($product->getStatus() != Mage_Catalog_Model_Product_Status::STATUS_ENABLED) {
			return false;
		}
	
		if (!$product->isVisibleInSiteVisibility()) {
			if ($product->getStoreId() == $storeId) {
				return false;
			}
			$urlData = Mage::getResourceSingleton('catalog/url')
				->getRewriteByProductStore(array($product->getId() => $storeId));
			if (!isset($urlData[$product->getId()])) {
				return false;
			}
			$product->setUrlDataObject(new Varien_Object($urlData));
			$visibility = $product->getUrlDataObject()->getVisibility();
			if (!in_array($visibility, $product->getVisibleInSiteVisibilities())) {
				return false;
			}
		}
	
		if (!$product->isSalable()) {
			throw new Mage_Core_Exception(null, self::EXCEPTION_CODE_NOT_SALABLE);
		}
	
		//$buyRequest = null;//$this->getBuyRequest();
	
		$cart->addProduct($product, $buyRequest);
		if (!$product->isVisibleInSiteVisibility()) {
			$cart->getQuote()->getItemByProduct($product)->setStoreId($storeId);
		}
	
		/* if ($delete) {
			$this->delete();
		} */
	
		return true;
	}
}