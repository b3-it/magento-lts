<?php

class Stala_Abo_Model_Contract extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('stalaabo/contract');
    }
}