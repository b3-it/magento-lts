<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 11:08
 */

class Bkg_VirtualGeo_Model_Product_Option extends Mage_Catalog_Model_Product_Option
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('virtualgeo/product_option');
    }

    /**
     * TODO: Remove me!
     * @return mixed
     * @throws Varien_Exception
     */
    public function getId() {
        return $this->getComponentType();
    }

    public function getType() {
        switch ($this->getComponentType()) {
            case Bkg_VirtualGeo_Model_Components_Componentproduct::COMPONENT_TYPE_GEOREF:
            default:
                return Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO;
        }
    }
}