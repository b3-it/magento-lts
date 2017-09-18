<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Multishipping checkout overview information
 *
 * @category Mage
 * @package Mage_Checkout
 * @author Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Checkout_Block_Multipage_Successview extends Mage_Sales_Block_Items_Abstract
{
	protected $_quote = null;
	protected $_order = null;
	
	/**
	 * Get multishipping checkout model
	 *
	 * @return Egovs_Checkout_Model_Multipage
	 */
	public function getCheckout() {
		return Mage::getSingleton ( 'mpcheckout/multipage' );
	}
	
	protected function _prepareLayout() {
		if ($headBlock = $this->getLayout ()->getBlock ( 'head' )) {
			$headBlock->setTitle ( Mage::helper ( 'checkout' )->__ ( 'Checkout Procedure' ) . " - " . $this->__ ( 'Review Order' ) );
		}
		return parent::_prepareLayout ();
	}
	
	protected function _beforeToHtml() {
		$this->getLayout()->getBlock('totals')->setTotals($this->getTotals());
		
		$this->getLayout()->getBlock('payment_info')->setPaymentInfo($this->getPayment());
		return $this;
	}
	
	/**
	 * Aktuelle Order laden
	 * 
	 * @return Mage_Sales_Model_Order
	 */
	protected function _getOrder() {
		if (is_null($this->_order)) {
			$lastOrderId = Mage::getSingleton ('checkout/session')->getLastOrderId();
			/* @var $order Mage_Sales_Model_Order */
			$this->_order = Mage::getSingleton ('sales/order')->load($lastOrderId);
		}
		
		return $this->_order;
	}
	
	/**
	 * Retrieve info block name
	 *
	 * @return string|false
	 */
	protected function _getInfoBlockName() {
		if ($info = $this->getPaymentInfo ()) {
			return 'payment.info.' . $info->getMethodInstance ()->getCode ();
		}
		return false;
	}
	
	/**
	 * Liefert die Rechnungsadresse
	 * 
	 * @return Mage_Sales_Model_Quote_Address
	 */
	public function getBillingAddress() {
		return $this->getQuote ()->getBillingAddress ();
	}
	
	/**
	 * Zahlinformationen ausgeben
	 * 
	 * @return string
	 */
	public function getPaymentHtml() {
		$block = null;
		try {
			$block = $this->getChildHtml('payment_info');
		} catch (Exception $e) {
			Mage::logException($e);
		}
		
		if (empty($block)) {
			return $this->__('No information available.');
		}
		
		return $block;
	}
	
	public function getItems() {
		return $this->getQuote()->getAllVisibleItems ();
	}
	
	public function getTotals() {
		return $this->getQuote()->getTotals();
	}
	
	public function getPayment() {
		return $this->getQuote()->getPayment();
	}
	
	public function getShippingAddress() {
		return $this->getQuote()->getShippingAddress();
	}
	
	public function getShippingAddressCount() {
		$count = $this->getData ( 'shipping_address_count' );
		if (is_null($count)) {
			$count = count ($this->getShippingAddresses());
			$this->setData('shipping_address_count', $count );
		}
		return $count;
	}
	
	public function getShippingAddressRate($address) {
		if ($rate = $address->getShippingRateByCode($address->getShippingMethod())) {
			return $rate;
		}
		return false;
	}
	
	public function getShippingPriceInclTax($address) {
		$exclTax = $address->getShippingAmount ();
		$taxAmount = $address->getShippingTaxAmount ();
		return $this->formatPrice($exclTax + $taxAmount);
	}
	
	public function getShippingPriceExclTax($address) {
		return $this->formatPrice($address->getShippingAmount());
	}
	
	public function formatPrice($price) {
		return $this->getQuote()->getStore()->formatPrice($price);
	}
	
	public function getShippingAddressItems($address) {
		return $address->getAllVisibleItems ();
	}
	
	public function getShippingAddressTotals($address) {
		$totals = $address->getTotals ();
		foreach ( $totals as $total ) {
			if ($total->getCode () == 'grand_total') {
				if ($address->getAddressType () == Mage_Sales_Model_Quote_Address::TYPE_BILLING) {
					$total->setTitle ( $this->__ ( 'Total' ) );
				} else {
					$total->setTitle ( $this->__ ( 'Total for this address' ) );
				}
			}
		}
		return $totals;
	}
	
	public function getTotal() {
		return $this->getQuote ()->getGrandTotal();
	}
	
	/**
	 * Retrieve virtual product collection array
	 *
	 * @return array
	 */
	public function getVirtualItems() {
		$items = array ();
		foreach ( $this->getBillingAddress ()->getItemsCollection () as $_item ) {
			if ($_item->isDeleted ()) {
				continue;
			}
			if ($_item->getProduct ()->getIsVirtual () && ! $_item->getParentItemId ()) {
				$items [] = $_item;
			}
		}
		return $items;
	}
	
	/**
	 * Retrieve quote
	 *
	 * @return Mage_Sales_Model_Quote
	 */
	public function getQuote() {
		if ($this->_quote == null) {
			$lastQuoteId = $this->getCheckout ()->getCheckout ()->getLastQuoteId ();
			$this->_quote = Mage::getModel ('sales/quote' )->setStoreId(Mage::app()->getStore()->getId())->load($lastQuoteId);
		}
		return $this->_quote;
	}
	
	public function isVirtual() {
		return ($this->getQuote()->isVirtual());
	}
	
	public function getBillinAddressTotals() {
		$_address = $this->getQuote()->getBillingAddress();
		return $this->getShippingAddressTotals($_address);
	}
	
	public function renderTotals($totals) {
		$colspan = $this->helper('tax')->displayCartBothPrices() ? 5 : 3;
		return $this->getChild('totals')->setTotals($totals)->renderTotals( - 1, $colspan );
	}
	
	public function getOrderId() {
		$order = $this->_getOrder();
		
		return $order->getIncrementId ();
	}
	
	public function getKassenzeichen() {
		$order = $this->_getOrder();
		if ($payment = $order->getPayment()) {
			$kzeichen = $payment->getData('kassenzeichen');
			if (($kzeichen != null) && (strlen($kzeichen) > 0)) {
				return $kzeichen;
			}
		}
		
		return false;
	}
}
