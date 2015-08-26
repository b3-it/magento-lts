<?php
/**
 * Configurable Downloadable Products SQL
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$attributeCode = 'replace_duplicates';
if (!$installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode)) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, array(
			'type'                    => 'int',
			'backend'                 => '',
			'frontend'                => '',
			'label'                   => 'Replace duplicates',
			'note'					  => 'Should already existing files will be overwritten?',
			'input'                   => 'select',
			'class'                   => '',
			'source'                  => '',
			'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible'                 => false,
			'required'                => true,
			'user_defined'            => false,
			'default'                 => false,
			'searchable'              => false,
			'filterable'              => false,
			'comparable'              => false,
			'visible_on_front'        => false,
			'unique'                  => false,
			'apply_to'                => Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE,
			'is_configurable'         => false,
			'used_in_product_listing' => true
	));
}

$installer->endSetup();