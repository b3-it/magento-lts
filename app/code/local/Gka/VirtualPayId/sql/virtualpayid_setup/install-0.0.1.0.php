<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'virtualpayid/payid'
 */
$table = $installer->getConnection()
	->newTable($installer->getTable('virtualpayid/payid'))
	->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity'  => true,
			'unsigned'  => true,
			'nullable'  => false,
			'primary'   => true,
			'autoincrement' => true,
			), 'ID')
	->addColumn('kassenzeichen', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
			), 'kassenzeichen')
	->addColumn('order_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned'  => true,
			'nullable'  => true,
			'default'   => '0',
			), 'Order Item ID')
	->addForeignKey(
		$installer->getFkName('virtualpayid/payid', 'order_item_id', 'sales/order_item', 'item_id'),
		'order_item_id', $installer->getTable('sales/order_item'), 'item_id',
		Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE
	)
	->setComment('Tuc Voucher Table')
;


$installer->getConnection()->createTable($table);

$installer->endSetup();