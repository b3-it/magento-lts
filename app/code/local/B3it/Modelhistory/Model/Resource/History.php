<?php
class B3it_Modelhistory_Model_Resource_History extends Mage_Core_Model_Resource_Db_Abstract 
{
    protected function _construct()
    {
        $this->_init('b3it_modelhistory/history_entries', 'id');
	 }
}
    