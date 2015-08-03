<?php

class Egovs_Informationservice_Model_Mysql4_Requesttype_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('informationservice/requesttype');
    }
}