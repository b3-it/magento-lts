<?php

class Sid_Framecontract_Model_Transmit extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('framecontract/transmit');
    }
}