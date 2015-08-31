<?php

class Stala_Abo_Model_Mysql4_Contract extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the abo_contract_id refers to the key field in your database table.
        $this->_init('stalaabo/contract', 'abo_contract_id');
    }
}