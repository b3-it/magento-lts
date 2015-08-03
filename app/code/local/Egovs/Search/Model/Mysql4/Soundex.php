<?php

class Egovs_Search_Model_Mysql4_Soundex extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the extstock_id refers to the key field in your database table.
        $this->_init('egovssearch/soundex', null);
    }
}