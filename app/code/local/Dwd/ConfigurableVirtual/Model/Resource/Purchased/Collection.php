<?php

class Dwd_ConfigurableVirtual_Model_Resource_Purchased_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Init resource model
     *
     */
    protected function _construct()
    {
        $this->_init('configvirtual/purchased');
    }
}
