<?php

class Dwd_Periode_Model_Mysql4_Periode_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('periode/periode');
    }
}