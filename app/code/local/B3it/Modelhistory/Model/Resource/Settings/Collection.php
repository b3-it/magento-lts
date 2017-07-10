<?php
class B3it_Modelhistory_Model_Resource_Settings_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    //use B3it_Modelhistory_Model_Resource_CollectionTrait;

    protected function _construct()
    {
        $this->_init('b3it_modelhistory/settings');
    }
}