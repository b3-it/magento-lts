<?php

class Egovs_Extnewsletter_Model_Mysql4_Queueproduct extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extnewsletter_id refers to the key field in your database table.
        $this->_init('extnewsletter/extnewsletter_queue_product', 'extnewsletter_queue_product_id');
    }
}