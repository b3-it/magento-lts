<?php

class Stala_Abo_Model_Mysql4_Deliver extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the abo_deliver_id refers to the key field in your database table.
        $this->_init('stalaabo/delivered', 'abo_deliver_id');
    }
    
}