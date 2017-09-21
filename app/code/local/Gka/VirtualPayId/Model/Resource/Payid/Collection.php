<?php

class Gka_VirtualPayId_Model_Resource_Payid_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualpayid/payid');
    }
}