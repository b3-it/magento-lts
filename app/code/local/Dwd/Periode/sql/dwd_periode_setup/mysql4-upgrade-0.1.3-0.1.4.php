<?php

$installer = $this;

$installer->startSetup();


$table = $installer->getConnection()
	->newTable($installer->getTable('periode/store_label'))
	->addColumn('periode_label_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity'  => true,
			'unsigned'  => true,
			'nullable'  => false,
			'primary'   => true,
	), 'Id')
	->addColumn('periode_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Periode')
	->addForeignKey('fk_periode_store_label','periode_id', $installer->getTable('periode/periode'), 'entity_id',
			Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Store')
	->addForeignKey('fk_store_store_label','store_id', $installer->getTable('core/store'), 'store_id',
					Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->addColumn('label', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(), 'Label')
	;
$installer->getConnection()->createTable($table);

$installer->endSetup(); 
