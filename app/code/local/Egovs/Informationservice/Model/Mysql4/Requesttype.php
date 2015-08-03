<?php

class Egovs_Informationservice_Model_Mysql4_Requesttype extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the informationservice_requesttype_id refers to the key field in your database table.
        $this->_init('informationservice/requesttype', 'requesttype_id');
    }
    
    
   
}