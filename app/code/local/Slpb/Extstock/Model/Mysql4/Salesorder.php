<?php

class Slpb_Extstock_Model_Mysql4_Salesorder extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extstock_id refers to the primary key field in your database table.
        $this->_init('extstock/salesorder', 'extstock_sales_order_id');
    }
}