<?php

class Gka_Flexprice_Model_Product_Price extends Mage_Catalog_Model_Product_Type_Price
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
    
    public function getBasePrice($product, $qty = null)
    {
    	$price = (float)0;
    	return $price;
    }
}
