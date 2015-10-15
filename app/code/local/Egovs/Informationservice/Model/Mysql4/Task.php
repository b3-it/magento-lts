<?php

class Egovs_Informationservice_Model_Mysql4_Task extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the informationservice_task_id refers to the key field in your database table.
        $this->_init('informationservice/task', 'task_id');
    }
}