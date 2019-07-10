<?php

/**
 *
 *  Produkt-Detailansicht; Überschreibt Bundle um die Verfügbarkeit als ProductStockAlert abzuspeichern
 *
 * @category  Egovs
 * @package   Egovs_EventBundle
 * @author    Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 * @author    Holger Kögel <​h.koegel@b3-it.de>
 * @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 * @license   ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Block_Checkout_Cart_Item_Renderer extends Mage_Bundle_Block_Checkout_Cart_Item_Renderer
{


    /**
     * Overloaded method for getting list of bundle options
     * Caches result in quote item, because it can be used in cart 'recent view' and on same page in cart checkout
     *
     * @return array
     */
    public function getOptionList() {
        return $this->getOptions($this->getItem());
    }

    public function getOptions(Mage_Catalog_Model_Product_Configuration_Item_Interface $item) {
        return $this->getSubItems($item);
    }

    public function getSubItems(Mage_Catalog_Model_Product_Configuration_Item_Interface $item) {

        $options = array();
        $product = $item->getProduct();

        /**
         * @var Mage_Bundle_Model_Product_Type
         */
        $typeInstance = $product->getTypeInstance(true);

        // get bundle options
        $optionsQuoteItemOption = $item->getOptionByCode('bundle_option_ids');
        $childs = $item->getChildren();
        $bundleOptionsIds = unserialize($optionsQuoteItemOption->getValue());
        if ($bundleOptionsIds) {
            /**
             * @var Mage_Bundle_Model_Mysql4_Option_Collection
             */
            $optionsCollection = $typeInstance->getOptionsByIds($bundleOptionsIds, $product);

            // get and add bundle selections collection
            $selectionsQuoteItemOption = $item->getOptionByCode('bundle_selection_ids');

            $selectionsCollection = $typeInstance->getSelectionsByIds(
                unserialize($selectionsQuoteItemOption->getValue()),
                $product
            );

            $bundleOptions = $optionsCollection->appendSelections($selectionsCollection, true);
            foreach ($bundleOptions as $bundleOption) {
                if ($bundleOption->getSelections()) {
                    $option = array(
                        'label' => $bundleOption->getTitle(),
                        'value' => array(),
                    );

                    $bundleSelections = $bundleOption->getSelections();

                    foreach ($bundleSelections as $bundleSelection) {
                        $qty = $this->getSelectionQty($product, $bundleSelection->getSelectionId()) * 1;
                        if ($qty) {
                            $quoteItem = $this->getSelectionQuoteItem($childs, $bundleSelection->getSelectionId());
                            $text = $qty . ' x ' . Mage::helper('eventbundle')->escapeHtml($bundleSelection->getName());
                            $text .= Mage::helper('eventbundle')->getAdditionalPriceInfo($quoteItem);
                            $option['value'][] = $text;
                        }
                    }

                    if ($option['value']) {
                        $options[] = $option;
                    }
                }
            }
        }

        return $options;
    }

    public function getSelectionQty($product, $selectionId) {
        $selectionQty = $product->getCustomOption('selection_qty_' . $selectionId);
        if ($selectionQty) {
            return $selectionQty->getValue();
        }
        return 0;
    }

    public function getSelectionQuoteItem($childs, $selectionId) {
        foreach ($childs as $child) {
            $id = $child->getOptionByCode('selection_id');
            if ($id->getValue() == $selectionId) {
                return $child;
            }
        }

        return NULL;
    }

    public function getSelectionFinalPrice(Mage_Catalog_Model_Product_Configuration_Item_Interface $item, $selectionProduct) {
        return $item->getProduct()->getPriceModel()->getSelectionFinalPrice(
            $item->getProduct(), $selectionProduct,
            $item->getQty() * 1,
            $this->getSelectionQty($item->getProduct(), $selectionProduct->getSelectionId())
        );
    }

    public function getSelectionPrice(Mage_Catalog_Model_Product_Configuration_Item_Interface $item, $selectionProduct) {
        return $item->getProduct()->getPriceModel()->getSelectionPrice(
            $item->getProduct(), $selectionProduct,
            $item->getQty() * 1,
            $this->getSelectionQty($item->getProduct(), $selectionProduct->getSelectionId())
        );
    }

}
