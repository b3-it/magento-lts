<?php

$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'sternchen', array(
    'label' => 'Sternchen',
	'type' => 'int',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => true,
    'user_defined' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
	'frontend_class'             => 'validate-number',
    'default' => '0',
));



$installer->addAttribute('catalog_product', 'slpb_limit', array(
    'label' => 'Limitiert',
    'input' => 'boolean',
	'type' => 'int',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '0',
));

$installer->endSetup(); 