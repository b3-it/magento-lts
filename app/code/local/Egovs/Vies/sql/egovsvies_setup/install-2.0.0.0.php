<?php
/* @var $this Mage_Core_Model_Resource_Setup */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
		DROP TABLE IF EXISTS {$this->getTable('egovsvies/group_auto_assignment')};
		CREATE TABLE {$this->getTable('egovsvies/group_auto_assignment')} (
		`entity_id` varchar(10) NOT NULL,
		`country_id` varchar(2) NOT NULL,
		`customer_group_id` smallint(5) unsigned NOT NULL,
		PRIMARY KEY (`entity_id`),
		CONSTRAINT `FK_EGOVS_AUTOASSIGN_CUSTOMER_GROUP_DIRECTORY_COUNTRY_ID` FOREIGN KEY (`country_id`)
			REFERENCES {$this->getTable('directory/country')}(`country_id`) ON DELETE CASCADE,
		CONSTRAINT `FK_EGOVS_AUTOASSIGN_CUSTOMER_GROUP_CUSTOMER_GROUP_ID` FOREIGN KEY (`customer_group_id`)
			REFERENCES {$this->getTable('customer/customer_group')}(`customer_group_id`) ON DELETE CASCADE
		) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");
//		Alte Spalten
// 		`company` tinyint(1) NOT NULL default 0,
// 		`taxvat` tinyint(3) NOT NULL default 0,
//
//		CONSTRAINT `EGOVS_UNIQUE_FIELDS` UNIQUE KEY (`country_id`, `company`, `taxvat`),

$installer->run("
		ALTER TABLE {$this->getTable('customer_group')}
		ADD `company` tinyint(1) NOT NULL default 0,
		ADD `taxvat` tinyint(3) NOT NULL default 0;
");

$installer->endSetup();