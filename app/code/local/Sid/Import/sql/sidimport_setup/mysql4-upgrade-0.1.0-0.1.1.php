<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sidimport/storage'), 'los_id')) {
	$installer->run("ALTER TABLE `{$installer->getTable('sidimport/storage')}`  ADD `los_id` int default 0");
	$installer->run("ALTER TABLE `{$installer->getTable('sidimport/storage')}`  ADD `type` varchar(100) default ''");
	$installer->run("ALTER TABLE `{$installer->getTable('sidimport/storage')}`  ADD `import_type` varchar(100) default ''");
	$installer->run("ALTER TABLE `{$installer->getTable('sidimport/storage')}`  ADD `price` decimal(10,2) default 0");
	$installer->run("ALTER TABLE `{$installer->getTable('sidimport/storage')}`  ADD `upload_time` datetime");
}





$installer->endSetup();