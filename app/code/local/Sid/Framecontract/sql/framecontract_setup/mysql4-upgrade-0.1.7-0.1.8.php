<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();


if (!$installer->getAttribute('catalog_product', 'manufacturer_name')) {
	$installer->addAttribute('catalog_product', 'manufacturer_name', array(
			'label' => 'Manufacturer',
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