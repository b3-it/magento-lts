<?php

class Slpb_Extstock_Model_Mysql4_Stockorder_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('extstock/stockorder');
    }
}