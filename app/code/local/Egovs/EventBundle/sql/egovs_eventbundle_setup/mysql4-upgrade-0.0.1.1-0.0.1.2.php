<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getAttribute('catalog_product', 'date_notsaleable')) {
	$installer->addAttribute('catalog_product', 'date_notsaleable', array(
			'label' => 'Set Product as not salable from Date',
			'input' => 'datetime',
			'type' => 'datetime',
			'backend' => 'eventbundle/entity_attribute_backend_datetime',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => true,
			'required' => false,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			//'source'    => 'eav/entity_attribute_source_boolean',
			//'default' => '1',
			//'option' => $option,
			'group' => 'General',
			'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
	));
	$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'date_notsaleable', 'apply_to', Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE);
}

if (!$installer->getAttribute('catalog_product', 'date_disable')) {
	$installer->addAttribute('catalog_product', 'date_disable', array(
			'label' => 'Set Product as disabled from Date',
			'input' => 'datetime',
			'type' => 'datetime',
			'backend' => 'eventbundle/entity_attribute_backend_datetime',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => true,
			'required' => false,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			//'source'    => 'eav/entity_attribute_source_boolean',
			//'default' => '1',
			//'option' => $option,
			'group' => 'General',
			'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
	));
	$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'date_disable', 'apply_to', Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE);
}

if (!$installer->getAttribute('catalog_product', 'personal_header_text')) {
	$installer->addAttribute('catalog_product', 'personal_header_text', array(
			'label' => 'Header Text for personal options',
			'input' => 'text',
			'type' => 'varchar',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
			'visible' => false,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'group' => 'personal',
			'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
	));
	$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'personal_header_text', 'apply_to', Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE);
}
$installer->endSetup();