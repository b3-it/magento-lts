<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 11:08
 */

class Bkg_VirtualGeo_Model_Bundle_Option extends Mage_Bundle_Model_Option
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('virtualgeo/bundle_option');
    }
}