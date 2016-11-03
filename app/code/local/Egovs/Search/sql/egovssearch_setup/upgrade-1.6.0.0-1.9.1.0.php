<?php
/**
 *
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package			Egovs_Search
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

if ($installer->getAttribute('catalog_product', 'product_available_in_stock')) {
	// Update attribute properties
	$installer->updateAttribute(
			'catalog_product',
			'product_available_in_stock',
			array('attribute_code' => 'search_available_in_stock')
	);
}

$installer->endSetup();