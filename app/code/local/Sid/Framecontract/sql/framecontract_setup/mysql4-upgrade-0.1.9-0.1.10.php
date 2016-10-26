<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('framecontract_vendor'), 'store_group')) {
	$installer->run("ALTER TABLE `{$installer->getTable('framecontract_vendor')}`  ADD `store_group` int default 0");
}





$installer->endSetup();