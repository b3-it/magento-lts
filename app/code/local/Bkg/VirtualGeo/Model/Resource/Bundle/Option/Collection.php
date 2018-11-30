<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 11:07
 */

class Bkg_VirtualGeo_Model_Resource_Bundle_Option_Collection extends Mage_Bundle_Model_Resource_Option_Collection
{
    /**
     * Init model and resource model
     *
     */
    protected function _construct()
    {
        $this->_init('virtualgeo/bundle_option');
    }

    /**
     * Joins values to options
     *
     * @param int $storeId
     * @return Mage_Bundle_Model_Resource_Option_Collection
     */
    public function joinValues($storeId)
    {
        return $this;
    }
}