<?php

class Gka_VirtualPayId_Model_Resource_Payid extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the voucher_id refers to the key field in your database table.
        $this->_init('virtualpayid/payid', 'id');
    }
    
 
}