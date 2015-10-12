<?php

class Egovs_Informationservice_Model_Mysql4_Task_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('informationservice/task');
    }
    
    public function getReportFull()
    {
    	return $this;
    } 
}