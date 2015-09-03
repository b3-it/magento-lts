<?php

$installer = $this;

$installer->startSetup();

$installer->addAttribute('customer', 'osc_customer_id', array(
    'label' => 'osc_customer_id',
	'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => false,
	'required' => false,
));

$installer->addAttribute('customer_address', 'osc_address_id', array(
    'label' => 'osc_address_id',
	'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => false,
	'required' => false,
));


$installer->addAttribute('catalog_category', 'osc_category_id', array(
    'label' => 'osc_category_id',
	'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => false,
	'required' => false,
));

$installer->addAttribute('catalog_product', 'osc_product_id', array(
    'label' => 'osc_product_id',
	'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => false,
	'required' => false,
));

$installer->addAttribute('catalog_product', 'kostentraeger', array(
    'label' => 'Kostenträger',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '',
));

$installer->addAttribute('catalog_product', 'kostenstelle', array(
    'label' => 'Kostenstelle',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '',
));




$installer->endSetup(); 