<?php

$installer = $this;

$installer->startSetup();

$producttypes = array(Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE,
					  Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL,
					  Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE);

$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'stationen_set', array(
		'type'                    => 'int',
		'backend'                 => '',
		'frontend'                => '',
		'label'                   => 'Stations Set',
		'input'                   => 'select',
		'class'                   => '',
		'source'                  => 'stationen/entity_attribute_source_set',
		'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'                 => true,
		'required'                => false,
		'user_defined'            => false,
		'default'                 => '0',
		'searchable'              => false,
		'filterable'              => false,
		'comparable'              => false,
		'visible_on_front'        => false,
		'unique'                  => false,
		'apply_to'                => $producttypes,
		'is_configurable'         => false,
		'used_in_product_listing' => false
));

$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'show_stations_suggest', array(
		'type'                    => 'int',
		'backend'                 => '',
		'frontend'                => '',
		'label'                   => 'Show Stations Suggest Box',
		'input'                   => 'select',
		'class'                   => '',
		'source'                  => 'eav/entity_attribute_source_boolean',
		'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'                 => true,
		'required'                => true,
		'user_defined'            => false,
		'default'                 => '0',
		'searchable'              => false,
		'filterable'              => false,
		'comparable'              => false,
		'visible_on_front'        => false,
		'unique'                  => false,
		'apply_to'                => $producttypes,
		'is_configurable'         => false,
		'used_in_product_listing' => false
));

$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'show_stations_map', array(
		'type'                    => 'int',
		'backend'                 => '',
		'frontend'                => '',
		'label'                   => 'Show Stations Map',
		'input'                   => 'select',
		'class'                   => '',
		'source'                  => 'eav/entity_attribute_source_boolean',
		'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'                 => true,
		'required'                => true,
		'user_defined'            => false,
		'default'                 => '0',
		'searchable'              => false,
		'filterable'              => false,
		'comparable'              => false,
		'visible_on_front'        => false,
		'unique'                  => false,
		'apply_to'                => $producttypes,
		'is_configurable'         => false,
		'used_in_product_listing' => false
));

$installer->endSetup(); 
$installer->installEntities();