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
    	$pre = $product->getPreconfiguredValues();
		$price = 0;
		if($pre && $pre->getFelxprice())
		{
			return floatval($pre->getFelxprice());
		}
        return parent::getFinalPrice($qty, $product);
    }
    
    public function getBasePrice($product, $qty = null)
    {
    	$price = (float)0;
    	return $price;
    }
}
