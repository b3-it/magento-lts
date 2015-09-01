<?php

$installer = $this;

$installer->startSetup();


$columnName = 'ibewi_maszeinheit';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
			'nullable' => true,
			'length' => 48,
			'default' => null,
			'comment' => 'ibewi_maszeinheit'
	));
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
			'nullable' => true,
			'length' => 48,
			'default' => null,
			'comment' => 'ibewi_maszeinheit'
	));
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/invoice_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/invoice_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
			'nullable' => true,
			'length' => 48,
			'default' => null,
			'comment' => 'ibewi_maszeinheit'
	));
}

$installer->endSetup(); 