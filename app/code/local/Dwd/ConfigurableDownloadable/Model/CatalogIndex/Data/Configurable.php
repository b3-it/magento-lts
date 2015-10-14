<?php
/**
 * Downloadable product data retriever
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_CatalogIndex_Data_Downloadable extends Mage_CatalogIndex_Model_Data_Virtual
{

    /**
     * Retrieve product type code
     *
     * @return string
     */
    public function getTypeCode() {
        return Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE;
    }

}
