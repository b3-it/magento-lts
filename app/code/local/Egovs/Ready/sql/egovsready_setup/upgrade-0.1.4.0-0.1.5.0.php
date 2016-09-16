<?php
/**
 *
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package			Egovs_Ready
 * @name            Egovs_Ready_Block_Catalog_Product_Price
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

// Update attribute properties
$installer->updateAttribute(
		'catalog_product',
		'delivery_time',
		'used_in_product_listing',
		true
);

$installer->updateAttribute(
		'catalog_product',
		'weight',
		'used_in_product_listing',
		true
);

$installer->endSetup();