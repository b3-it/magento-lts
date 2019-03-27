<?php
class Gka_InternalPayId_Model_Product_Observer extends Varien_Object
{


    public function onSalesQuoteItemSetProduct($observer) {
        $quoteItem = $observer->getQuoteItem();
        /** @var $product Mage_Catalog_Model_Product */
        $product = $observer->getProduct();
        /** @var $quote Mage_Sales_Model_Quote */
        $quote = $quoteItem->getQuote();
        if ($product && $product->getTypeId() != Gka_InternalPayId_Model_Product_Type_Internalpayid::TYPE_INTERNAL_PAYID) {
            $quoteItem->setInternalPayid(null);
            return $this;
        }


        /**
         * @var Mage_Sales_Model_Quote_Item_Option $payId Kassenzeichen
         */
        $payId = $product->getCustomOption('pay_id');
        if (is_null($payId) || $payId->isEmpty() || !$payId->getValue()) {
            $quote->removeItem($quoteItem->getId());
            $quoteItem->setInternalPayid(null);
            $quote->save();
            Mage::throwException(Mage::helper('virtualpayid')->__('No external Payment code available!'));
        }
        $payId = $payId->getValue();
        /**
         * @var Varien_Object $payClient Enthält Fachverfahren (Mandant/Bewirtschafter an ePayBL)
         */
        $payClient = $product->getCustomOption('pay_client');
        if (
            is_null($payClient)
            || $payClient->isEmpty()
            || !$payClient->getValue()
            || !preg_match('/^[\w]+\/[\w]+$/', $payClient->getValue())
        ) {
            $quote->removeItem($quoteItem->getId());
            $quoteItem->setInternalPayid(null);
            $quote->save();
            Mage::throwException(Mage::helper('virtualpayid')->__('No external operator available!'));
        }
        $payClient = $payClient->getValue();

        /*
         * Format: Mandant/Bewirtschafter/Kassenzeichen
         * $payClient = Mandant/Bewirtschafter
         */
        $quoteItem->setInternalPayid(sprintf('%s/%s', $payClient, $payId));

        $br = $quoteItem->getBuyRequest();
        $specialPrice = Gka_Flexprice_Helper_Data::parseFloat($br->getAmount());


        if ($specialPrice > 0) {
            $quoteItem->setCustomPrice($specialPrice);
            $quoteItem->setOriginalCustomPrice($specialPrice);
            $quoteItem->getProduct()->setIsSuperMode(true);
        } else {
            //throw new Exception('Preis darf nicht null sein!');
        }
    }
}
