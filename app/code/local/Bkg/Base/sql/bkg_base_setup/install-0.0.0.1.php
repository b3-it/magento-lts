<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
/**
 * Add attributes to the eav/attribute table
 */
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'product_code', array(
		'type'                    => Varien_Db_Ddl_Table::TYPE_VARCHAR,
		'backend'                 => '',
		'frontend'                => '',
		'label'                   => 'Product Code',
		'input'                   => 'text',
		'class'                   => '',
		'source'                  => '',
		'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'                 => false,
		'required'                => true,
		'user_defined'            => false,
		'default'                 => '',
		'searchable'              => false,
		'filterable'              => false,
		'comparable'              => false,
		'visible_on_front'        => false,
		'unique'                  => false,
		'is_configurable'         => false,
		
));


$installer->endSetup();