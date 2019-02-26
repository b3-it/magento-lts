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

        $collection->setOrder('sku', Mage_Sales_Model_Resource_Order_Item_Collection::SORT_ORDER_ASC);
    }
}
