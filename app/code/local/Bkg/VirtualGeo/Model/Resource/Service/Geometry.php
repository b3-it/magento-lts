<?php

class Bkg_VirtualGeo_Model_Resource_Service_Geometry extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('virtualgeo/service_geometry', 'id');
    }
}

