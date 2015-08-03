<?php

$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('informationservice_request')} ADD COLUMN `result_product_id` int(11) unsigned DEFAULT 0;");


$installer->addAttribute('catalog_product', 'infoservice_is_master_product', array(
    'label' => 'Is Informationservice Master Product',
    'input' => 'select',
	'type' => 'int',
	'source' => 'eav/entity_attribute_source_boolean',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'user_defined' => true,
    'searchable' => false,
    'comparable' => false,
	'required' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '0',
	'group' => 'General'
));

$installer->run("ALTER TABLE {$this->getTable('informationservice_request')} DROP COLUMN `result_sku`;");

$installer->endSetup(); 
