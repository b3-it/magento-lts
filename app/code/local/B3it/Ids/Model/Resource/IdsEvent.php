<?php
class B3it_Ids_Model_Resource_IdsEvent extends Mage_Core_Model_Resource_Db_Abstract 
{
    protected function _construct()
    {
        $this->_init('b3it_ids/ids_events', 'id');
	 }
}
    