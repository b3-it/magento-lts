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

$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'storage_time', 'note', 'Duration in days to keep files stored. Use 0 to store files unlimited.');
 
