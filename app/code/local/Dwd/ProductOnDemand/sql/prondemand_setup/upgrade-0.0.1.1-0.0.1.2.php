<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$attributeCode = 'pod_show_reference_period';
if (!$installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode)) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, array(
			'type'                    => 'int',
			'backend'                 => '',
			'frontend'                => '',
			'label'                   => 'Show Reference Period',
			'note'					  => 'Is the reference period visible for customers?',
			'input'                   => 'select',
			'class'                   => '',
			'source'                  => 'eav/entity_attribute_source_boolean',
			'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible'                 => false,
			'required'                => true,
			'user_defined'            => false,
			'default'                 => 1,
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