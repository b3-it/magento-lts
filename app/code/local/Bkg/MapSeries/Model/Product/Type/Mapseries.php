<?php

/**
 * Mapseries product type implementation
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Bkg_Mapseries_Model_Product_Type_Mapseries extends Mage_Catalog_Model_Product_Type_Grouped
{
    const TYPE_CODE = 'mapseries';
    const TYPE_MAPSERIES = 'mapseries';
    
    public function isMapseries()
    {
    	return true;
    }
}
