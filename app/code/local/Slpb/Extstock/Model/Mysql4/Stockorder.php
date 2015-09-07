<?php

class Slpb_Extstock_Model_Mysql4_Stockorder extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extstock_stockorder_id refers to the key field in your database table.
        $this->_init('extstock/stockorder', 'extstock_stockorder_id');
    }
}