<?php

class Dwd_Sales_Model_Shipping extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sales/shipping');
    }
}