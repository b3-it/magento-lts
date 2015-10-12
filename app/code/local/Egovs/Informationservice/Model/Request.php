<?php

class Egovs_Informationservice_Model_Request extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('informationservice/request');
    }
    
    
}