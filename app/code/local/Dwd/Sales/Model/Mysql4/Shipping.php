<?php

class Dwd_Sales_Model_Mysql4_Shipping extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the sales_shipping_id refers to the key field in your database table.
        $this->_init('sales/shipping', 'sales_shipping_id');
    }
}