<?php
/**
 *
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package         Egovs_ProductFile
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/* @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/*
 * Falls user_defined => true benutzt wird, muss ein Attributset bzw. eine Gruppe angegeben werden.
 * Falls user_defined => false so wird es in alle Attributsets integriert (Gruppe: General)
 */

$entityTypeId = Mage_Catalog_Model_Product::ENTITY;
$attributeId = 'productfile';
if (!$installer->getAttribute($entityTypeId, $attributeId)) {
	$installer->addAttribute($entityTypeId, $attributeId, array(
// 			'group' => 'General',
			'label' => 'ProductFile path',
			'type' => 'varchar',
			'input' => 'text',
			'source' => '',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
			'visible' => false,
			'required' => false,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'user_defined' => false,
			'default' => '',
	));
}

$attributeId = 'productimage';
if (!$installer->getAttribute($entityTypeId, $attributeId)) {
	$installer->addAttribute($entityTypeId, $attributeId, array(
// 			'group' => 'General',
			'label' => 'ProductImage path',
			'type' => 'varchar',
			'input' => 'text',
			'source' => '',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
			'visible' => false,
			'required' => false,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'user_defined' => false,
			'default' => '',
	));
}

$attributeId = 'productfiledescription';
if (!$installer->getAttribute($entityTypeId, $attributeId)) {
	$installer->addAttribute($entityTypeId, $attributeId, array(
// 			'group' => 'General',
			'label' => 'ProductFile description',
			'type' => 'varchar',
			'input' => 'media_image',
			'frontend' => 'productfile/entity_attribute_frontend_productfile',
			'source' => '',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
			'visible' => false,
			'required' => false,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => true,
			'visible_in_advanced_search' => false,
			'user_defined' => false,
			'default' => '',
	));
}

$installer->endSetup();