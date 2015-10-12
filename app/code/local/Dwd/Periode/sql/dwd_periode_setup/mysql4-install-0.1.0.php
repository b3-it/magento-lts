<?php

$installer = $this;

$installer->startSetup();


$table = $installer->getConnection()
    ->newTable($installer->getTable('periode/periode'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity ID')
    ->addColumn('type', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'zeitraum oder zeitdauer')
    ->addColumn('from', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'from')
    ->addColumn('to', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'to')
    ->addColumn('duration', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Zeitdauer')
    ->addColumn('label', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(), 'Label')
    ->addColumn('unit', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Einheit')
    ->addColumn('price', Varien_Db_Ddl_Table::TYPE_NUMERIC, array(10,2), array('default'=>'0'), 'Preis')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Produkt')
    ->addForeignKey('fk_periode_product','product_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
     ;
$installer->getConnection()->createTable($table);


$columnName = 'period_type';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			'nullable' => true,
			'default' => 0,
			'comment' => 'Period Type'
	));
}
$columnName = 'period_start';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_DATETIME,
			'nullable' => true,
			'default' => null,
			'comment' => 'Period Start'
	));
}
$columnName = 'period_end';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_DATETIME,
			'nullable' => true,
			'default' => null,
			'comment' => 'Period End'
	));
}

$columnName = 'period_id';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			'unsigned' => true,
			'nullable' => true,
			'default' => null,
			'comment' => 'Period ID'
	));
}

$installer->endSetup(); 