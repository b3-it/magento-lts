<?php

class TuChemnitz_Voucher_Model_Resource_Tan_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('tucvoucher/tan');
    }
}