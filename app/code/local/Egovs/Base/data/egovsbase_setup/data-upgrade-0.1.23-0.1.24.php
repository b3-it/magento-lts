<?php

/* @var $installer Mage_Eav_Model_Entity_Setup*/
$installer = $this;
$installer->startSetup();

if ($installer->getConnection()->tableColumnExists($installer->getTable('customer/entity'), 'created_at')) {
	$installer->run("ALTER TABLE `{$installer->getTable('customer/entity')}` MODIFY `created_at` timestamp not null default 0");
}

if ($installer->getConnection()->tableColumnExists($installer->getTable('customer/entity'), 'updated_at')) {
	$installer->run("ALTER TABLE `{$installer->getTable('customer/entity')}` MODIFY `updated_at` timestamp not null default 0");
}

$installer->endSetup();