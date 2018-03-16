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
	public function onSalesQuoteItemSetProduct($observer) {
		$quoteItem = $observer->getQuoteItem();
		/** @var $product Mage_Catalog_Model_Product */
		$product = $observer->getProduct();
		/** @var $quote Mage_Sales_Model_Quote */
		$quote = $quoteItem->getQuote();
		if ($product && $product->getTypeId() != Gka_Flexprice_Model_Product_Type::TYPE_CODE) {
			return $this;
		}


		$br = $quoteItem->getBuyRequest();
		$specialPrice = (float)($br->getAmount());


		if ($specialPrice > 0) {
				$quoteItem->setCustomPrice($specialPrice);
				$quoteItem->setOriginalCustomPrice($specialPrice);
				$quoteItem->getProduct()->setIsSuperMode(true);
		} else {
			//throw new Exception('Preis darf nicht null sein!');
		}
	}

}
