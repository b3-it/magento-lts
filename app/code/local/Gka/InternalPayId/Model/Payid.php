<?php

class Gka_InternalPayId_Model_Payid extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('internalpayid/payid');
    }
    

}