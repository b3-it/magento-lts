<?php

class Egovs_Paymentbase_Model_Sepa_Mandate_History extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('paymentbase/sepa_mandate_history');
    }
    
}