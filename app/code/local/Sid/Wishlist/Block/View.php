<?php
class Sid_Wishlist_Block_View extends Sid_Wishlist_Block_View_Quote_Abstract
{
	/**
	 * Prepare Quote Item Product URLs
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		$this->prepareItemUrls();
	}
	
	/**
	 * Prepariert die URLs der Merklistereinträge
	 * 
	 * @return void
	 */
	public function prepareItemUrls()
	{
		$products = array();
		/* @var $item Mage_Sales_Model_Quote_Item */
		foreach ($this->getItems() as $item) {
			$product    = $item->getProduct();
			$option     = $item->getOptionByCode('product_type');
			if ($option) {
				$product = $option->getProduct();
			}
	
			if ($item->getStoreId() != Mage::app()->getStore()->getId()
					&& !$item->getRedirectUrl()
					&& !$product->isVisibleInSiteVisibility()
			) {
				$products[$product->getId()] = $item->getStoreId();
			}
		}
	
		if ($products) {
			$products = Mage::getResourceSingleton('catalog/url')
				->getRewriteByProductStore($products);
			foreach ($this->getItems() as $item) {
				$product    = $item->getProduct();
				$option     = $item->getOptionByCode('product_type');
				if ($option) {
					$product = $option->getProduct();
				}
	
				if (isset($products[$product->getId()])) {
					$object = new Varien_Object($products[$product->getId()]);
					$item->getProduct()->setUrlDataObject($object);
				}
			}
		}
	}
	
	/**
	 * Darf dieser Benutzer Bestellungen abgeben
	 * 
	 * @return bool
	 */
	public function isAuthorizedOrderer() {
		return Mage::helper('sidwishlist')->isAuthorizedOrderer();
	}
	
	public function getAddAllToCartUrl() {
		if (!$this->isAuthorizedOrderer()) {
			return false;
		}
		
		return Mage::getUrl('*/quote_item/allcart');
	}
	/**
	 * Liefert URL um Item zum Einkaufswagen hinzuzufügen
	 *
	 * @param string $item Item
	 *
	 * @return  string
	 */
	public function getItemAddToCartUrl($item)
	{
		$urlParamName = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;
		$continueUrl  = Mage::helper('core')->urlEncode(
				Mage::getUrl('*/*/*', array(
						'_current'      => true,
						'_use_rewrite'  => true,
						'_store_to_url' => true,
				))
		);
	
		$urlParamName = Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED;
		$params = array(
				'item' => is_string($item) ? $item : '%item%',
				$urlParamName => $continueUrl
		);
		return Mage::getUrl('sidwishlist/quote_item/cart', $params);
	}
	
	public function chooseTemplate()
	{
		$itemsCount = $this->getItemsCount() ? $this->getItemsCount() : $this->getQuote()->getItemsCount();
		if ($itemsCount) {
			$this->setTemplate($this->getCartTemplate());
		} else {
			$this->setTemplate($this->getEmptyTemplate());
		}
	}
	
	public function hasError()
	{
		return $this->getQuote()->getHasError();
	}
	
	public function getItemsSummaryQty()
	{
		return $this->getQuote()->getItemsSummaryQty();
	}
	
	public function isWishlistActive()
	{
		$isActive = $this->_getData('is_wishlist_active');
		if ($isActive === null) {
			$isActive = Mage::getStoreConfig('wishlist/general/active')
			&& Mage::getSingleton('customer/session')->isLoggedIn();
			$this->setIsWishlistActive($isActive);
		}
		return $isActive;
	}
	
	public function getCheckoutUrl()
	{
		return $this->getUrl('checkout/onepage', array('_secure'=>true));
	}
	
	public function getContinueShoppingUrl()
	{
		$url = $this->getData('continue_shopping_url');
		if (is_null($url)) {
			$url = Mage::getSingleton('checkout/session')->getContinueShoppingUrl(true);
			if (!$url) {
				$url = Mage::getUrl();
			}
			$this->setData('continue_shopping_url', $url);
		}
		return $url;
	}
	
	public function getBackUrl() {
		return Mage::getUrl('*/*/index', array('_secure'=>true));
	}
	
	public function getFormActionUrl() {
		return Mage::getUrl('*/*/updatePost', array('_secure'=>true));
	}
	
	public function getDeleteAllUrl() {
		return Mage::getUrl('*/quote_item/deleteAll', array('_secure'=>true, 'id' => $this->getQuote()->getId()));
	}
	
	public function getIsVirtual()
	{
		return $this->helper('checkout/cart')->getIsVirtualQuote();
	}
	
	/**
	 * Return list of available checkout methods
	 *
	 * @param string $nameInLayout Container block alias in layout
	 * @return array
	 */
	public function getMethods($nameInLayout)
	{
		if ($this->getChild($nameInLayout) instanceof Mage_Core_Block_Abstract) {
			return $this->getChild($nameInLayout)->getSortedChildren();
		}
		return array();
	}
	
	/**
	 * Return HTML of checkout method (link, button etc.)
	 *
	 * @param string $name Block name in layout
	 * @return string
	 */
	public function getMethodHtml($name)
	{
		$block = $this->getLayout()->getBlock($name);
		if (!$block) {
			Mage::throwException(Mage::helper('checkout')->__('Invalid method: %s', $name));
		}
		return $block->toHtml();
	}
	
	/**
	 * Return customer quote items
	 *
	 * @return array
	 */
	public function getItems() {
		if ($this->getCustomItems()) {
			return $this->getCustomItems();
		}
	
		return parent::getItems();
	}
	
	public function hasItems() {
		$items = $this->getItems();
		
		if (empty($items)) {
			return false;
		}
		
		return true;			
	}
	
	public function hasQtyGranted() {
		return $this->getQuote()->hasQtyGranted();
	}
	
	public function hasSaleableItems() {
		return $this->getQuote()->hasSaleableItems();
	}

	public function hasQtyOrdered() {
	    return $this->getQuote()->hasQtyOrdered();
    }
}