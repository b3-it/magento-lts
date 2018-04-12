<?php
class Bkg_VirtualGeo_Model_Resource_Service_Geometry_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/service_geometry');
    }
}
