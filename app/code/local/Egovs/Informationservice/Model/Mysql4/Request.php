<?php

class Egovs_Informationservice_Model_Mysql4_Request extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the informationservice_request_id refers to the key field in your database table.
        $this->_init('informationservice/request', 'request_id');
    }
}