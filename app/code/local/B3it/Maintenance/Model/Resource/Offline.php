<?php
class B3it_Maintenance_Model_Resource_Offline extends Mage_Core_Model_Resource_Db_Abstract 
{
    protected function _construct()
    {
        $this->_init('maintenance/offline', 'id');
	 }
}
    