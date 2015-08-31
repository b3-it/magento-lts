<?php
class Stala_Extcustomer_Model_Mysql4_Salesdiscount extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extcustomer_sales_discount_id refers to the key field in your database table.
        $this->_init('extcustomer/salesdiscount', 'extcustomer_sales_discount_id');
    }
}