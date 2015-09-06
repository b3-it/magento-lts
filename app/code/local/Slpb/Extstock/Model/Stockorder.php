<?php

class Slpb_Extstock_Model_Stockorder extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('extstock/stockorder');
    }
}