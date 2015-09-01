<?php

class Sid_Framecontract_Model_Mysql4_Contract extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the framecontract_contract_id refers to the key field in your database table.
        $this->_init('framecontract/contract', 'framecontract_contract_id');
    }
}