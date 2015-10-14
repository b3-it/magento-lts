<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd Installer
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();

/*
$installer->run("
		ALTER TABLE {$installer->getTable('icd_account')} ADD COLUMN `next_delete` datetime DEFAULT NULL;
");
*/
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('icd_debug')};
CREATE TABLE {$this->getTable('icd_debug')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `account_id` int(11) unsigned NOT NULL ,
  `action` varchar(255) NOT NULL default '',
  `param` varchar(255) NOT NULL default '',
  `return_code` varchar(10) NOT NULL default '',
  `return_msg` varchar(255) NOT NULL default '',
  `created_time` timestamp default CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`account_id`) REFERENCES `{$this->getTable('icd_account')}`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
		DROP TABLE IF EXISTS {$this->getTable('icd_groups')};
		CREATE TABLE {$this->getTable('icd_groups')} (
		`id` int(11) unsigned NOT NULL auto_increment,
		`account_id` int(11) unsigned NOT NULL ,
		`application` varchar(255) NOT NULL default '',
		`count` int(11) default 0,
		`created_time` timestamp default CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`),
		FOREIGN KEY (`account_id`) REFERENCES `{$this->getTable('icd_account')}`(`id`) ON DELETE CASCADE,
		INDEX icd_application_idx (`application`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
		DROP TABLE IF EXISTS {$this->getTable('icd_attributes')};
		CREATE TABLE {$this->getTable('icd_attributes')} (
		`id` int(11) unsigned NOT NULL auto_increment,
		`account_id` int(11) unsigned NOT NULL ,
		`attribute` varchar(255) NOT NULL default '',
		`count` int(11) default 0,
		`created_time` timestamp default CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`),
		FOREIGN KEY (`account_id`) REFERENCES `{$this->getTable('icd_account')}`(`id`) ON DELETE CASCADE,
		INDEX icd_attributes_idx (`attribute`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");



$installer->endSetup(); 