<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('framecontract_vendor'), 'u4_main_apar_id')) {
	$installer->run("ALTER TABLE `{$installer->getTable('framecontract_vendor')}`  ADD `u4_main_apar_id` varchar(25) default ''");
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('framecontract_contract'), 'u4_responsible')) {
	$installer->run("ALTER TABLE `{$installer->getTable('framecontract_contract')}`  ADD `u4_responsible` varchar(50) default ''");
}





$installer->endSetup();