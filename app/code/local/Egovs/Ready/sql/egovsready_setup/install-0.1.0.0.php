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
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$entityTypeId = 'catalog_product';
$attributeId = 'delivery_time';
if (!$installer->getAttribute($entityTypeId, $attributeId)) {
	$installer->addAttribute(
			$entityTypeId,
			$attributeId,
			array(
					'label'                      => 'Lieferzeit',
					'input'                      => 'text',
					'required'                   => 0,
					'user_defined'               => 1,
					'default'                    => '2-3 Tage',
					'group'                      => 'General',
					'global'                     => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
					'visible'                    => 1,
					'filterable'                 => 0,
					'searchable'                 => 0,
					'comparable'                 => 1,
					'visible_on_front'           => 1,
					'visible_in_advanced_search' => 1,
					'used_in_product_listing'    => 1,
					'is_html_allowed_on_front'   => 1,
			)
	);
}

// Update attribute properties
$installer->updateAttribute(
		'catalog_product',
		'weight',
		'used_in_product_listing',
		true
);

$attributeId = 'meta_autogenerate';
if (!$installer->getAttribute($entityTypeId, $attributeId)) {
	$installer->addAttribute(
			'catalog_product',
			$attributeId,
			array(
					'label' => 'Auto-Generate Meta-Information',
					'input' => 'select',
					'source' => 'eav/entity_attribute_source_boolean',
					'required' => false,
					'user_defined' => true,
					'default' => '0',
					'group' => 'Meta Information',
					'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
					'searchable' => false,
					'comparable' => false,
					'filterable' => false,
					'visible' => true,
					'visible_on_front' => false,
					'visible_in_advanced_search' => false,
					'used_in_product_listing' => false,
					'is_html_allowed_on_front' => false,
			)
	);
}

$installer->endSetup();