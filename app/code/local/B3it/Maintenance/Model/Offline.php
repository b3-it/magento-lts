<?php
class B3it_Maintenance_Model_Offline extends Mage_Core_Model_Abstract 
{
	
	const OFFLINE_NO = 0;
	const OFFLINE_YES = 1;
	const OFFLINE_SCHEDULED = 2;
	
	
    protected function _construct()
    {
        $this->_init('maintenance/offline');
	 }
}
    