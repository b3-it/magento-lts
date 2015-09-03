<?php

class Slpb_Verteiler_Model_Mysql4_Verteiler_Customer extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the verteiler_verteiler_id refers to the key field in your database table.
        $this->_init('verteiler/verteiler_customer', 'verteiler_customer_id');
    }
    

}