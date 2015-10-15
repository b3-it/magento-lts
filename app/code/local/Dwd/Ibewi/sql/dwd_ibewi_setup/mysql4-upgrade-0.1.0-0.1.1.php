<?php

$installer = $this;

$installer->startSetup();





$installer->addAttribute('catalog_product', 'ibewi_maszeinheit', array(
    'label' => 'IBEWI Maßeinheit',
    'input' => 'select',
	'type' => 'varchar',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => true,
    'is_user_defined' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
	'source'=>'ibewi/entity_attribute_source_einheit',
    'default' => '',
	//'option' => $option,
	'group' => 'General',
));


$installer->addAttribute('catalog_product', 'kostenstelle', array(
    'label' => 'Kostenstelle',
    'input' => 'select',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '',
));

$installer->endSetup(); 