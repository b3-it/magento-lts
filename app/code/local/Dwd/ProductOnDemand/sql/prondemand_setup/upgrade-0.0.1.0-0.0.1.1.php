<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$columnName = 'valid_to';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('downloadable/link_purchased_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('downloadable/link_purchased_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
			'nullable' => true,
			'default' => null,
			'comment' => 'Valid to Date'
	));
}

$installer->endSetup();