<?php

class Bkg_VirtualAccess_Model_Product_Price extends Mage_Catalog_Model_Product_Type_Price
{
    /**
     * Retrieve product final price
     *
     * @param integer $qty
     * @param Mage_Catalog_Model_Product $product
     * 
     * @return float
     */
    public function getFinalPrice($qty=null, $product) {
        return parent::getFinalPrice($qty, $product);
    }
}
