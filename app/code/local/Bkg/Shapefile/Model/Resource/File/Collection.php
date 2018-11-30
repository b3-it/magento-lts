<?php
class Bkg_Shapefile_Model_Resource_File_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_shapefile/file');
    }
}
