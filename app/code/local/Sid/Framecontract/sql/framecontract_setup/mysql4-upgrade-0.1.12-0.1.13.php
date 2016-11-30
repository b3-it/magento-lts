<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('framecontract_los'), 'link_valid_to')) {
	$installer->run("ALTER TABLE `{$installer->getTable('framecontract_los')}`  ADD `link_valid_to` smallint unsigned default 14");
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('framecontract_los'), 'link_valid_to_modified')) {
	$installer->run("ALTER TABLE `{$installer->getTable('framecontract_los')}`  ADD `link_valid_to_modified` datetime");
}





$installer->endSetup();