<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();



if (!$installer->getConnection()->tableColumnExists($installer->getTable('eventmanager/participant'), 'phone')) {
	$installer->run("
			ALTER TABLE {$installer->getTable('eventmanager/participant')}
			ADD COLUMN phone varchar(255) NOT NULL default '';
			");
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('eventmanager/participant'), 'country')) {
	$installer->run("
			ALTER TABLE {$installer->getTable('eventmanager/participant')}
			ADD COLUMN country varchar(255) NOT NULL default '';
			");
}


$installer->endSetup();