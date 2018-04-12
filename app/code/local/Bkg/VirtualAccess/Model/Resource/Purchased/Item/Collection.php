<?php

class Bkg_VirtualAccess_Model_Resource_Purchased_Item_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Init resource model
     *
     */
    protected function _construct()
    {
        $this->_init('virtualaccess/purchased_item');
    }
}
