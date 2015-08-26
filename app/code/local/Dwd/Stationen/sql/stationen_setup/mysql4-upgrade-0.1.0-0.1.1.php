<?php

$installer = $this;

$installer->startSetup();

$columnName = 'station_id';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			'unsigned'  => true,
			'nullable' => true,
			'default' => null,
			'comment' => 'Station ID'
	));
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			'unsigned'  => true,
			'nullable' => true,
			'default' => null,
			'comment' => 'Station ID'
	));
}

$installer->endSetup(); 
$installer->installEntities();