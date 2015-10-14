<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Add attributes to the eav/attribute table
 */
$attributeCode = 'pod_type_id';
if (!$installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode)) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, array(
			'type'                    => Varien_Db_Ddl_Table::TYPE_VARCHAR,
			'backend'                 => '',
			'frontend'                => '',
			'label'                   => 'Type ID',
			'input'                   => '',
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
			'unique'                  => true,
			'apply_to'                => Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND,
			'is_configurable'         => false,
			'used_in_product_listing' => true
	));
}
$attributeCode = 'pod_base_url';
if (!$installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode)) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, array(
			'type'                    => Varien_Db_Ddl_Table::TYPE_VARCHAR,
			'backend'                 => '',
			'frontend'                => '',
			'label'                   => 'Base URL for Application',
			'input'                   => '',
			'class'                   => 'validate-url',
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
			'apply_to'                => Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND,
			'is_configurable'         => false,
			'used_in_product_listing' => true
	));
}

$attributeCode = 'pod_availibility_url';
if (!$installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode)) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, array(
			'type'                    => Varien_Db_Ddl_Table::TYPE_VARCHAR,
			'backend'                 => '',
			'frontend'                => '',
			'label'                   => 'Availibility URL for Application',
			'input'                   => '',
			'class'                   => 'validate-url',
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
			'apply_to'                => Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND,
			'is_configurable'         => false,
			'used_in_product_listing' => true
	));
}

$attributeCode = 'pod_storage_time';
if (!$installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode)) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, array(
			'type'                    => 'int',
			'backend'                 => '',
			'frontend'                => '',
			'label'                   => 'Storage time',
			'note'					  => 'Duration in hours to keep files stored',
			'input'                   => '',
			'class'                   => 'validate-digits',
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
			'apply_to'                => Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND,
			'is_configurable'         => false,
			'used_in_product_listing' => true
	));
}

$installer->endSetup();