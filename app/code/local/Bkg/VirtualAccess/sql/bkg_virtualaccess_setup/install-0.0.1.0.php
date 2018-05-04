<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'virtualaccess/purchased'
 */
if (!$installer->tableExists($installer->getTable('virtualaccess/purchased')))
{
$table = $installer->getConnection()
	->newTable($installer->getTable('virtualaccess/purchased'))
	->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
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
	->addColumn('product_sku', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			), 'Product sku')
	->addColumn('product_code', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			), 'Product CODE')			
	->addColumn('base_url', Varien_Db_Ddl_Table::TYPE_TEXT, 512, array(
			), 'Base Url')
	->addColumn('oracle_account_id', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			), 'Acoount Id Form BGK System')
	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, 6, array(
			'default'   => '0',
			), 'Status')
	->addColumn('sync_status', Varien_Db_Ddl_Table::TYPE_INTEGER, 6, array(
			'default'   => '0',
			), 'Synchronisation Status to BKG System')			
	->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
					'unsigned'  => true,
					'nullable'  => true,
					'default'   => '0',
			), 'Customer ID')			
	->addIndex($installer->getIdxName('virtualaccess/purchased', 'order_id'), 'order_id')
	->addIndex($installer->getIdxName('virtualaccess/purchased', 'order_item_id'), 'order_item_id')
	->addIndex($installer->getIdxName('virtualaccess/purchased', 'customer_id'), 'customer_id')
	->addForeignKey(
		$installer->getFkName('virtualaccess/purchased', 'customer_id', 'customer/entity', 'entity_id'),
		'customer_id', $installer->getTable('customer/entity'), 'entity_id',
		Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE
	)
	->addForeignKey(
		$installer->getFkName('virtualaccess/purchased', 'order_id', 'sales/order', 'entity_id'),
		'order_id', $installer->getTable('sales/order'), 'entity_id',
		Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE
	)
	->setComment('Virtual Access Purchased Table');
	$installer->getConnection()->createTable($table);
}


if (!$installer->tableExists($installer->getTable('virtualaccess/periodical_abo')))
{
	$installer->run("

			-- DROP TABLE IF EXISTS {$this->getTable('virtualaccess/periodical_abo')};
			CREATE TABLE {$this->getTable('virtualaccess/periodical_abo')} (
			`id` int(11) unsigned NOT NULL auto_increment,
			`first_order_id` int(11) unsigned NOT NULL,
			`first_orderitem_id` int(11) unsigned NOT NULL,
			`current_order_id` int(11) unsigned NOT NULL,
			`current_orderitem_id` int(11) unsigned NOT NULL,
			`purchased_id` int(11) unsigned default NULL,
			`renewal_status` smallint(6) NOT NULL default '0',
			`status` smallint(6) NOT NULL default '0',
			`accounting_type` smallint(6) NOT NULL default '0',
			`start_date` datetime NULL,
			`stop_date` datetime NULL,
			PRIMARY KEY (`id`),
			FOREIGN KEY (`first_order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE,
			FOREIGN KEY (`current_order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE,
			FOREIGN KEY (`first_orderitem_id`) REFERENCES `{$this->getTable('sales/order_item')}`(`item_id`) ON DELETE CASCADE,
			FOREIGN KEY (`current_orderitem_id`) REFERENCES `{$this->getTable('sales/order_item')}`(`item_id`) ON DELETE CASCADE,
			FOREIGN KEY (`purchased_id`) REFERENCES `{$this->getTable('virtualaccess/purchased')}`(`id`) ON DELETE SET NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			");
}


if (!$installer->tableExists($installer->getTable('virtualaccess/service_log')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualaccess/service_log')};
	 CREATE TABLE {$installer->getTable('virtualaccess/service_log')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `purchased_id` int(11) unsigned NOT NULL,
	  `created_at` datetime default now(),
	  `status` smallint(6) unsigned NOT NULL default '0',
	  `message` varchar(255) default '',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`purchased_id`) REFERENCES `{$this->getTable('virtualaccess/purchased')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

/**
 * Add attributes to the eav/attribute table
 */
$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'virtualaccess_base_url', array(
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
		'apply_to'                => Bkg_VirtualAccess_Model_Product_Type::TYPE_CODE,
		'is_configurable'         => false,
		'used_in_product_listing' => true
));

