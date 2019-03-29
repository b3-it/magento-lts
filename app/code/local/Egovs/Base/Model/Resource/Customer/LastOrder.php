<?php

class Egovs_Base_Model_Resource_Customer_LastOrder extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('customer/entity', 'entity_id');
    }
}
