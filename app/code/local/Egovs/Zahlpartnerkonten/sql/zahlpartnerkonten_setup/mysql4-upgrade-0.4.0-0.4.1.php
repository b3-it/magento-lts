<?php

$installer = $this;

$installer->startSetup();

/* @var $installer Mage_Eav_Model_Entity_Setup */
$attributeId = 'comment';

	//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
	if (!$installer->getConnection()->tableColumnExists($installer->getTable('zpkonten/pool'), $attributeId)) {
		$installer->getConnection()->addColumn(
				$installer->getTable('zpkonten/pool'),
				$attributeId,
				'varchar(1024) DEFAULT null'
		);
	}

$installer->endSetup(); 