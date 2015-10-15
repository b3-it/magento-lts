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
 * Create table 'configdownloadable/link_file'
 */
if (!$installer->getConnection()->isTableExists($installer->getTable('configdownloadable/link_file'))) {
	$table = $installer->getConnection()
		->newTable($installer->getTable('configdownloadable/link_file'))
		->addColumn('file_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'identity'  => true,
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
		), 'Link ID')
		->addColumn('number_in_use', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'nullable'  => true,
		), 'Number in use')
		->addColumn('link_file', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
		), 'Link File')
		->addColumn('link_type', Varien_Db_Ddl_Table::TYPE_TEXT, 20, array(
		), 'Link Type')
		->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
				'nullable' => true,
				'default' => null,
		), 'Creation Date')
		->addIndex($installer->getIdxName('configdownloadable/link_file', 'link_file'), 'link_file')
		->setComment('Configurable Downloadable Link File Table')
	;
	$installer->getConnection()->createTable($table);
}

$columnName = 'created_at';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('downloadable/link'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('downloadable/link'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
			'nullable' => true,
			'default' => null,
			'comment' => 'Creation Date'
	));
}

$columnName = 'updated_at';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('downloadable/link'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('downloadable/link'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
			'nullable' => true,
			'default' => null,
			'comment' => 'Update Date'
	));
}

$columnName = 'valid_to';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('downloadable/link'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('downloadable/link'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
			'nullable' => true,
			'default' => null,
			'comment' => 'Valid to Date'
	));
}
$columnName = 'link_file_id';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('downloadable/link'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('downloadable/link'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			'unsigned'  => true,
			'nullable' => true,
			'default' => null,
			'comment' => 'Link File ID'
	));
	$installer->getConnection()->addForeignKey(
			$installer->getFkName('downloadable/link', 'link_file_id', 'configdownloadable/link_file', 'file_id'),
			$installer->getTable('downloadable/link'), 'link_file_id',
			$installer->getTable('configdownloadable/link_file'), 'file_id'
	);	
}
$columnName = 'link_station_id';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('downloadable/link'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('downloadable/link'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			'unsigned'  => true,
			'nullable' => true,
			'default' => null,
			'comment' => 'Link Station ID'
	));
	$installer->getConnection()->addForeignKey(
			$installer->getFkName('downloadable/link', $columnName, 'stationen/stationen', 'entity_id'),
			$installer->getTable('downloadable/link'), $columnName,
			$installer->getTable('stationen/stationen'), 'entity_id'
	);
}
$installer->endSetup();