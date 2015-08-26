<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'configvirtual/purchased'
 */
$table = $installer->getConnection()
	->newTable($installer->getTable('configvirtual/purchased'))
	->addColumn('purchased_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity'  => true,
			'unsigned'  => true,
			'nullable'  => false,
			'primary'   => true,
			), 'Purchased ID')
	->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'default'   => '0',
			), 'Order ID')
	->addColumn('order_increment_id', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
			), 'Order Increment ID')
	->addColumn('order_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'nullable'  => false,
			'default'   => '0',
			), 'Order Item ID')
	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
			'nullable'  => false,
			), 'Date of creation')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
			'nullable'  => false,
			), 'Date of modification')
	->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'nullable'  => true,
			'default'   => '0',
			), 'Customer ID')
	->addColumn('product_name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			), 'Product name')
	->addColumn('product_sku', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			), 'Product sku')
	->addIndex($installer->getIdxName('configvirtual/purchased', 'order_id'), 'order_id')
	->addIndex($installer->getIdxName('configvirtual/purchased', 'order_item_id'), 'order_item_id')
	->addIndex($installer->getIdxName('configvirtual/purchased', 'customer_id'), 'customer_id')
	->addForeignKey(
		$installer->getFkName('configvirtual/purchased', 'customer_id', 'customer/entity', 'entity_id'),
		'customer_id', $installer->getTable('customer/entity'), 'entity_id',
		Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE
	)
	->addForeignKey(
		$installer->getFkName('configvirtual/purchased', 'order_id', 'sales/order', 'entity_id'),
		'order_id', $installer->getTable('sales/order'), 'entity_id',
		Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE
	)
	->setComment('Configurable Virtual Purchased Table')
;
$installer->getConnection()->createTable($table);

/**
 * Create table 'configvirtual/purchased_credential'
 */
$table = $installer->getConnection()
	->newTable($installer->getTable('configvirtual/purchased_credential'))
	->addColumn('credential_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity'  => true,
			'unsigned'  => true,
			'nullable'  => false,
			'primary'   => true,
	), 'Credential ID')
	->addColumn('is_shareable', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'nullable'  => false,
			'default'   => '0',
	), 'Is Shareable')
	->addColumn('username', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
	), 'Username')
	->addColumn('password', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
	), 'Password')
	->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'nullable'  => true,
			'default'   => '0',
	), 'Customer ID')
	->addColumn('status', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
	), 'Status')
	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
			'nullable'  => false,
	), 'Creation Time')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
			'nullable'  => false,
	), 'Update Time')
	->addIndex($installer->getIdxName('configvirtual/purchased_credential', 'customer_id'), 'customer_id')
	->setComment('Configurable Virtual Purchased Credential Table')
;
$installer->getConnection()->createTable($table);

/**
 * Create table 'configvirtual/purchased_item'
 */
$table = $installer->getConnection()
	->newTable($installer->getTable('configvirtual/purchased_item'))
	->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity'  => true,
			'unsigned'  => true,
			'nullable'  => false,
			'primary'   => true,
	), 'Item ID')
	->addColumn('purchased_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'nullable'  => false,
			'default'   => '0',
	), 'Purchased ID')
	->addColumn('order_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'default'   => '0',
	), 'Order Item ID')
	->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'nullable'  => true,
			'default'   => '0',
	), 'Product ID')
	->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'nullable'  => true,
			'default'   => '0',
	), 'Categrory ID')
	->addColumn('external_link_url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			), 'External Link Url')
	->addColumn('station_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
	), 'Station ID')
	->addColumn('credential_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'nullable'  => true,
			'default'   => '0',
	), 'Credential ID')
	->addColumn('status', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
	), 'Status')
	->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
			'nullable'  => false,
	), 'Creation Time')
	->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
			'nullable'  => false,
	), 'Update Time')
	->addColumn('valid_until', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
			'nullable'  => false,
	), 'Update Time')
	->addIndex($installer->getIdxName('configvirtual/purchased_item', 'order_item_id'), 'order_item_id')
	->addIndex($installer->getIdxName('configvirtual/purchased_item', 'purchased_id'), 'purchased_id')
	->addIndex($installer->getIdxName('configvirtual/purchased_item', 'credential_id'), 'credential_id')
	->addForeignKey(
			$installer->getFkName(
					'configvirtual/purchased_item',
					'credential_id',
					'configvirtual/purchased_credential',
					'credential_id'
			),
			'credential_id', $installer->getTable('configvirtual/purchased_credential'), 'credential_id',
			Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
	)
	->addForeignKey(
		$installer->getFkName(
			'configvirtual/purchased_item',
			'purchased_id',
			'configvirtual/purchased',
			'purchased_id'
		),
		'purchased_id', $installer->getTable('configvirtual/purchased'), 'purchased_id',
		Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
	)
	->addForeignKey(
		$installer->getFkName(
			'configvirtual/purchased_item',
			'order_item_id',
			'sales/order_item',
			'item_id'
		),
		'order_item_id', $installer->getTable('sales/order_item'), 'item_id',
		Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE
	)
	->setComment('Configurable Virtual Purchased Item Table')
;
$installer->getConnection()->createTable($table);

/**
 * Add attributes to the eav/attribute table
 */
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'configvirtual_base_url', array(
		'type'                    => Varien_Db_Ddl_Table::TYPE_VARCHAR,
		'backend'                 => '',
		'frontend'                => '',
		'label'                   => 'Base URL for Application',
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
		'apply_to'                => Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL,
		'is_configurable'         => false,
		'used_in_product_listing' => true
));

$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'always_create_new_credentials', array(
		'type'                    => 'int',
		'backend'                 => '',
		'frontend'                => '',
		'label'                   => 'Always create new credentials',
		'input'                   => 'select',
		'class'                   => '',
		'source'                  => 'eav/entity_attribute_source_boolean',
		'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'                 => false,
		'required'                => false,
		'user_defined'            => false,
		'default'                 => '1',
		'searchable'              => false,
		'filterable'              => false,
		'comparable'              => false,
		'visible_on_front'        => false,
		'unique'                  => false,
		'apply_to'                => Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL,
		'is_configurable'         => false,
		'used_in_product_listing' => true
));

$installer->endSetup();