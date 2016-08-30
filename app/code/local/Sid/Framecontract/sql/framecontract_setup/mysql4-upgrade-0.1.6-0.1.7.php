<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();


if (!$installer->getAttribute('catalog_product', 'ean')) {
	$installer->addAttribute('catalog_product', 'ean', array(
			'label' => 'EAN',
			'input' => 'text',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => true,
			'required' => false,
			'is_user_defined' => false,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'group' => 'General',
	));
}

if (!$installer->getAttribute('catalog_product', 'supplier_sku')) {
	$installer->addAttribute('catalog_product', 'supplier_sku', array(
			'label' => 'Supplier Sku',
			'input' => 'text',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => true,
			'required' => false,
			'is_user_defined' => false,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'group' => 'General',
	));
}



$installer->endSetup();