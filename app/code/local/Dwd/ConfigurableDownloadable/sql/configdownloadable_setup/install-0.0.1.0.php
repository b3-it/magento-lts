<?php
/**
 * Configurable Downloadable Products SQL
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'configdownloadable/link'
 */
if (!$installer->getConnection()->isTableExists($installer->getTable('configdownloadable/link'))) {
	$table = $installer->getConnection()
		->newTable($installer->getTable('configdownloadable/link'))
		->addColumn('link_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'identity'  => true,
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Link ID')
		->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'default'   => '0',
		), 'Product ID')
		->addColumn('sort_order', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'default'   => '0',
		), 'Sort order')
		->addColumn('number_of_downloads', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'nullable'  => true,
		), 'Number of downloads')
		->addColumn('is_shareable', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'default'   => '0',
		), 'Shareable flag')
		->addColumn('link_pattern', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Link Url')
		->addColumn('link_type', Varien_Db_Ddl_Table::TYPE_TEXT, 20, array(
		), 'Link Type')
		->addColumn('sample_url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Sample Url')
		->addColumn('sample_file', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Sample File')
		->addColumn('sample_type', Varien_Db_Ddl_Table::TYPE_TEXT, 20, array(
		), 'Sample Type')
		->addIndex($installer->getIdxName('configdownloadable/link', 'product_id'), 'product_id')
		->addIndex(
			$installer->getIdxName('configdownloadable/link', array('product_id','sort_order')),
			array('product_id','sort_order')
		)
		->addForeignKey(
			$installer->getFkName('configdownloadable/link', 'product_id', 'catalog/product', 'entity_id'),
			'product_id', $installer->getTable('catalog/product'), 'entity_id',
			Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
		->setComment('Configurable Downloadable Link Table')
	;
	$installer->getConnection()->createTable($table);
}
/**
 * Create table 'configdownloadable/link_price'
*/
if (!$installer->getConnection()->isTableExists($installer->getTable('configdownloadable/link_price'))) {
	$table = $installer->getConnection()
		->newTable($installer->getTable('configdownloadable/link_price'))
		->addColumn('price_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'identity'  => true,
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Price ID')
		->addColumn('link_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'default'   => '0',
		), 'Link ID')
		->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'default'   => '0',
		), 'Website ID')
		->addColumn('price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
				'nullable'  => false,
				'default'   => '0.0000',
		), 'Price')
		->addIndex($installer->getIdxName('configdownloadable/link_price', 'link_id'), 'link_id')
		->addForeignKey(
			$installer->getFkName('configdownloadable/link_price', 'link_id', 'configdownloadable/link', 'link_id'),
			'link_id', $installer->getTable('configdownloadable/link'), 'link_id',
			Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
		)
		->addIndex($installer->getIdxName('configdownloadable/link_price', 'website_id'), 'website_id')
		->addForeignKey(
			$installer->getFkName('configdownloadable/link_price', 'website_id', 'core/website', 'website_id'),
			'website_id', $installer->getTable('core/website'), 'website_id',
			Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
		)
		->setComment('Configurable Downloadable Link Price Table')
	;
	$installer->getConnection()->createTable($table);
}

/**
 * Create table 'configdownloadable/link_title'
 */
if (!$installer->getConnection()->isTableExists($installer->getTable('configdownloadable/link_title'))) {
	$table = $installer->getConnection()
		->newTable($installer->getTable('configdownloadable/link_title'))
		->addColumn('title_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'identity'  => true,
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Title ID')
		->addColumn('link_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'default'   => '0',
		), 'Link ID')
		->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'default'   => '0',
		), 'Store ID')
		->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Title')
		->addIndex(
				$installer->getIdxName(
						'configdownloadable/link_title',
						array('link_id', 'store_id'),
						Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE
				),
				array('link_id', 'store_id'),
				array('type'=>Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE)
		)
		->addIndex($installer->getIdxName('configdownloadable/link_title', 'link_id'), 'link_id')
		->addForeignKey(
			$installer->getFkName('configdownloadable/link_title', 'link_id', 'configdownloadable/link', 'link_id'),
			'link_id', $installer->getTable('configdownloadable/link'), 'link_id',
			Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
		)
		->addIndex($installer->getIdxName('configdownloadable/link_title', 'store_id'), 'store_id')
		->addForeignKey(
			$installer->getFkName('configdownloadable/link_title', 'store_id', 'core/store', 'store_id'),
			'store_id', $installer->getTable('core/store'), 'store_id',
			Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
		)
		->setComment('Link Title Table')
	;
	$installer->getConnection()->createTable($table);
}		

/**
 * Create table 'configdownloadable/product_price_indexer_idx'
 */
if (!$installer->getConnection()->isTableExists($installer->getTable('configdownloadable/product_price_indexer_idx'))) {
	$table = $installer->getConnection()
		->newTable($installer->getTable('configdownloadable/product_price_indexer_idx'))
		->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Entity ID')
		->addColumn('customer_group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Customer Group ID')
		->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Website ID')
		->addColumn('min_price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
				'nullable'  => false,
				'default'   => '0.0000',
		), 'Minimum price')
		->addColumn('max_price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
				'nullable'  => false,
				'default'   => '0.0000',
		), 'Maximum price')
		->setComment('Indexer Table for price of Configurable Downloadable products')
	;
	$installer->getConnection()->createTable($table);
}
/**
 * Create table 'configdownloadable/product_price_indexer_tmp'
 */
if (!$installer->getConnection()->isTableExists($installer->getTable('configdownloadable/product_price_indexer_tmp'))) {
	$table = $installer->getConnection()
		->newTable($installer->getTable('configdownloadable/product_price_indexer_tmp'))
		->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Entity ID')
		->addColumn('customer_group_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Customer Group ID')
		->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Website ID')
		->addColumn('min_price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
				'nullable'  => false,
				'default'   => '0.0000',
		), 'Minimum price')
		->addColumn('max_price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
				'nullable'  => false,
				'default'   => '0.0000',
		), 'Maximum price')
		->setComment('Temporary Indexer Table for price of Configurable Downloadable products')
		->setOption('type', 'MEMORY')
	;
	$installer->getConnection()->createTable($table);
}
/**
 * Add attributes to the eav/attribute table
 */
// $attributeCode = 'filename_pattern';
// if (!$installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode)) {
// 	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, array(
// 			'type'                    => Varien_Db_Ddl_Table::TYPE_VARCHAR,
// 			'backend'                 => '',
// 			'frontend'                => '',
// 			'label'                   => 'Pattern for filenames',
// 			'input'                   => '',
// 			'class'                   => '',
// 			'source'                  => '',
// 			'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
// 			'visible'                 => false,
// 			'required'                => true,
// 			'user_defined'            => false,
// 			'default'                 => '',
// 			'searchable'              => false,
// 			'filterable'              => false,
// 			'comparable'              => false,
// 			'visible_on_front'        => false,
// 			'unique'                  => false,
// 			'apply_to'                => Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE,
// 			'is_configurable'         => false,
// 			'used_in_product_listing' => true
// 	));
// }

$attributeCode = 'storage_time';
if (!$installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode)) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, array(
			'type'                    => 'int',
			'backend'                 => '',
			'frontend'                => '',
			'label'                   => 'Storage time',
			'note'					  => 'Duration in days to keep files stored',
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
			'unique'                  => false,
			'apply_to'                => Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE,
			'is_configurable'         => false,
			'used_in_product_listing' => true
	));
}

$installer->endSetup();