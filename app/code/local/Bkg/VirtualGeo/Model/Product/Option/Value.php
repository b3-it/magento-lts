<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 11:08
 */

class Bkg_VirtualGeo_Model_Product_Option_Value extends Mage_Catalog_Model_Product_Option_Value
{
    protected function _construct() {
        $this->_init('virtualgeo/product_option_value');
    }

    public function getTitle() {
        return $this->getName();
    }

    public function getValuesByOption($optionIds, $option_id, $store_id)
    {
        $collection = Mage::getResourceModel('virtualgeo/product_option_value_collection')
            ->addFieldToFilter('component_type', $option_id)
            ->getValuesByOption($optionIds, $store_id);

        return $collection;
    }
}