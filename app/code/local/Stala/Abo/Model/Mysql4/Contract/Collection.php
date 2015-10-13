<?php

class Stala_Abo_Model_Mysql4_Contract_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stalaabo/contract');
    }
}