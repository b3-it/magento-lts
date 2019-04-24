<?php

/**
 * Class Slpb_Base_Model_Observer
 *
 * @category  Slpb
 * @package   Slpb_Base
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2019 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Slpb_Base_Model_Observer
{
    public function onSalesOrderItemCollectionSetSalesOrder($observer) {
        $collection = $observer->getCollection();
        if (!($collection instanceof Mage_Sales_Model_Resource_Order_Item_Collection)) {
            return;
        }

        //Numsort
        $collection->setOrder('sku + 0', Mage_Sales_Model_Resource_Order_Item_Collection::SORT_ORDER_ASC);
        //Alphasort
        $collection->setOrder('sku', Mage_Sales_Model_Resource_Order_Item_Collection::SORT_ORDER_ASC);
    }

    public function onSalesQuoteItemCollectionLoadBefore($observer) {
        $collection = $observer->getQuoteItemCollection();
        if (!($collection instanceof Mage_Sales_Model_Resource_Quote_Item_Collection)) {
            return;
        }

        //Numsort
        $collection->setOrder('sku + 0', Mage_Sales_Model_Resource_Order_Item_Collection::SORT_ORDER_ASC);
        //Alphasort
        $collection->setOrder('sku', Mage_Sales_Model_Resource_Order_Item_Collection::SORT_ORDER_ASC);
    }

    public function onAdminhtmlSalesOrderCreateProcessData ($observer) {
        /** @var \Mage_Adminhtml_Model_Sales_Order_Create $orderCreateModel */
        $orderCreateModel = $observer->getOrderCreateModel();
        if (!$orderCreateModel instanceof Mage_Adminhtml_Model_Sales_Order_Create) {
            return;
        }

        //Resort items by SKU after add to cart
        //Quote is already loaded, so we do it this way
        $itemsCollection = $orderCreateModel->getQuote()->getItemsCollection();
        $items = $itemsCollection->getItems();
        uasort($items, array(__CLASS__, 'compare'));
        foreach ($items as $k => $item) {
            $itemsCollection->removeItemByKey($k);
            $itemsCollection->addItem($item);
        }
    }

    public static function compare($a, $b) {
        $aSku = $a->getSku();
        $bSku = $b->getSku();
        if ($aSku === $bSku) {
            return 0;
        }
        if (is_numeric($aSku) && is_numeric($bSku)) {
            return ($aSku > $bSku) ? +1 : -1;
        }

        return strcmp($aSku, $bSku);
    }
}
