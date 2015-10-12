<?php
/**
 * Configurable Downloadable Products Price Model
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Product_Price extends Mage_Downloadable_Model_Product_Price
{
    /**
     * Retrieve product final price
     *
     * @param integer                    $qty     Anzahl
     * @param Mage_Catalog_Model_Product $product Produkt
     * 
     * @return float
     */
    public function getFinalPrice($qty=null, $product) {
        return parent::getFinalPrice($qty, $product);
    }
}
