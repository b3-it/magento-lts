<?php

class Dwd_Periode_Model_Mysql4_Periode extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the periode_periode_id refers to the key field in your database table.
        $this->_init('periode/periode', 'entity_id');
    }
}