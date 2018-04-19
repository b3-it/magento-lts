<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 11:06
 */

class Bkg_VirtualGeo_Model_Resource_Product_Option extends Mage_Catalog_Model_Resource_Product_Option
{
    /**
     * Initialize connection and define resource
     *
     */
    protected function _construct()
    {
        $this->_init('virtualgeo/product_option', 'id');
    }
}