<?php

$installer = $this;

$installer->startSetup();

$columnName = 'created_at';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('pdftemplate/template'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('pdftemplate/template'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
			'nullable' => true,
			'default' => null,
			'comment' => 'Creation Date'
	));
}

$columnName = 'updated_at';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('pdftemplate/template'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('pdftemplate/template'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
			'nullable' => true,
			'default' => null,
			'comment' => 'Update Date'
	));
}

$installer->endSetup(); 