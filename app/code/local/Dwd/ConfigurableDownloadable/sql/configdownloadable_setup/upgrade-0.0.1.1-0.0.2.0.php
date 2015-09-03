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

$columnName = 'data_valid_from';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('downloadable/link'), $columnName)) {
	$installer->run("
		ALTER TABLE {$installer->getTable('downloadable/link')}
		ADD COLUMN $columnName TIMESTAMP NULL DEFAULT NULL COMMENT 'Data valid From' AFTER `updated_at`;
	");
}

$columnName = 'data_valid_to';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('downloadable/link'), $columnName)) {
	$installer->run("
		ALTER TABLE {$installer->getTable('downloadable/link')}
		ADD COLUMN $columnName TIMESTAMP NULL DEFAULT NULL COMMENT 'Data valid To' AFTER `data_valid_from`;
	");
}

$columnName = 'periode_label';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('downloadable/link'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('downloadable/link'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
			'length' => 255,
			'nullable' => true,
			'default' => null,
			'comment' => 'Label of Periode'
	));
}
$installer->endSetup();