<?php

class Gka_InternalPayId_Model_Resource_Payid_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('internalpayid/payid');
    }
}