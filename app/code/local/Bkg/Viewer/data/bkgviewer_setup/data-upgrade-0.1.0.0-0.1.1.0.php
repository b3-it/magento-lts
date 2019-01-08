<?php
/**
 * Configurable Downloadable Products Data
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
    $applyTo = array();
    $applyTo[] = Bkg_MapSeries_Model_Product_Type_Mapseries::TYPE_CODE;
    $applyTo[] = Bkg_VirtualGeo_Model_Product_Type::TYPE_CODE;
    $installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'geocomposit', 'apply_to', implode(',', $applyTo));

 
