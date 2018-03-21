<?php
class Gka_Flexprice_Model_Product_Observer extends Varien_Object
{
	/**
	 * Wenn Produkt in Quote gesetzt wird
	 *
	 * @param Varien_Event_Observer $observer Observer
	 *
	 * @return Gka_Flexprice_Model_Product_Observer
	 */
	public function onSalesQuoteItemSetProduct(Varien_Event_Observer $observer)
	{
		$quoteItem = $observer->getQuoteItem();
		/** @var $product Mage_Catalog_Model_Product */
		$product = $observer->getProduct();
		/** @var $quote Mage_Sales_Model_Quote */
		$quote = $quoteItem->getQuote();
		if ($product && $product->getTypeId() != Gka_Flexprice_Model_Product_Type::TYPE_CODE) {
			return $this;
		}

		$br = $quoteItem->getBuyRequest();
		$specialPrice = Gka_Flexprice_Helper_Data::parseFloat($br->getAmount());

		if ( ($specialPrice > 0) OR $product->getAllowPriceZero() ) {
				$quoteItem->setCustomPrice($specialPrice);
				$quoteItem->setOriginalCustomPrice($specialPrice);
				$quoteItem->getProduct()->setIsSuperMode(true);
		}
		else {
			throw new Exception('Price must not be zero!');
		}
	}

}
