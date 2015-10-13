<?php
abstract class Sid_Wishlist_Block_View_Quote_Abstract extends Mage_Core_Block_Template
{
	protected $_customer = null;
	protected $_checkout = null;
	protected $_quote    = null;

	protected $_totals;
	protected $_itemRenders = array();

	public function __construct()
	{
		parent::__construct();
		$this->addItemRender('default', 'sidwishlist/view_quote_item_renderer', 'sid/wishlist/view/quote/item/default.phtml');
	}

	/**
	 * Add renderer for item product type
	 *
	 * @param   string $productType
	 * @param   string $blockType
	 * @param   string $template
	 * @return  Mage_Checkout_Block_Cart_Abstract
	 */
	public function addItemRender($productType, $blockType, $template)
	{
		$this->_itemRenders[$productType] = array(
				'block' => $blockType,
				'template' => $template,
				'blockInstance' => null
		);
		return $this;
	}
	
	
	
	public function clearItemRenderer()
	{
		$this->_itemRenders = array();
		return $this;
	}

	/**
	 * Get renderer information by product type code
	 *
	 * @deprecated please use getItemRendererInfo() method instead
	 * @see getItemRendererInfo()
	 * @param   string $type
	 * @return  array
	 */
	public function getItemRender($type)
	{
		return $this->getItemRendererInfo($type);
	}

	/**
	 * Get renderer information by product type code
	 *
	 * @param   string $type
	 * @return  array
	 */
	public function getItemRendererInfo($type)
	{
		if (isset($this->_itemRenders[$type])) {
			return $this->_itemRenders[$type];
		}
		return $this->_itemRenders['default'];
	}

	/**
	 * Get renderer block instance by product type code
	 *
	 * @param   string $type
	 * @return  array
	 */
	public function getItemRenderer($type)
	{
		if (!isset($this->_itemRenders[$type])) {
			$type = 'default';
		}
		if (is_null($this->_itemRenders[$type]['blockInstance'])) {
			$this->_itemRenders[$type]['blockInstance'] = $this->getLayout()
			->createBlock($this->_itemRenders[$type]['block'])
			->setTemplate($this->_itemRenders[$type]['template'])
			->setRenderedBlock($this);
		}

		return $this->_itemRenders[$type]['blockInstance'];
	}


	/**
	 * Get logged in customer
	 *
	 * @return Mage_Customer_Model_Customer
	 */
	public function getCustomer()
	{
		if (null === $this->_customer) {
			$this->_customer = Mage::getSingleton('customer/session')->getCustomer();
		}
		return $this->_customer;
	}

	/**
	 * Get checkout session
	 *
	 * @return Mage_Checkout_Model_session
	 */
	public function getCheckout()
	{
		if (null === $this->_checkout) {
			$this->_checkout = Mage::getSingleton('sidwishlist/session');
		}
		return $this->_checkout;
	}

	/**
	 * Get active quote
	 *
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function getQuote()
	{
		if (null === $this->_quote) {
			$this->_quote = $this->getCheckout()->getQuote();
		}
		return $this->_quote;
	}

	/**
	 * Get all cart items
	 *
	 * @return array
	 */
	public function getItems()
	{
		return $this->getQuote()->getAllVisibleItems();
	}

	/**
	 * Get item row html
	 *
	 * @param   Sid_Wishlist_Model_Quote_Item $item
	 * @return  string
	 */
	public function getItemHtml(Sid_Wishlist_Model_Quote_Item $item)
	{
		$renderer = $this->getItemRenderer($item->getProductType())->setItem($item);
		return $renderer->toHtml();
	}

	public function getTotals()
	{
		return $this->getTotalsCache();
	}

	public function getTotalsCache()
	{
		if (empty($this->_totals)) {
			$this->_totals = $this->getQuote()->getTotals();
		}
		return $this->_totals;
	}

	/**
	 * Check if can apply msrp to totals
	 *
	 * @return bool
	 */
	public function canApplyMsrp()
	{
		if (!$this->getQuote()->hasCanApplyMsrp() && Mage::helper('catalog')->isMsrpEnabled()) {
			$this->getQuote()->collectTotals();
		}
		return $this->getQuote()->getCanApplyMsrp();
	}
}
