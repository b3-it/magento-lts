<?php
/**
 * SQL installer
 * 
 * @category	B3it
 * @package		B3it_Ids
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer   = $this;
$connection  = $installer->getConnection();

$installer->startSetup();


$installer->run("
		DROP TABLE IF EXISTS {$this->getTable('ids_events')};
		CREATE TABLE {$this->getTable('ids_events')} (
		`id` int(11) unsigned NOT NULL auto_increment,
		  `name` varchar(128) NOT NULL,
		  `value` text NOT NULL,
		  `page` varchar(255) NOT NULL,
		  `userid` int(11) unsigned NOT NULL,
		  `session` varchar(32) NOT NULL,
		  `ip` varchar(15) NOT NULL,
		  `reaction` varchar(32) default '',
		  `impact` int(11) unsigned NOT NULL,
		  `created` datetime default now(),
		PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");



$installer->run("
		DROP TABLE IF EXISTS {$this->getTable('ids_events_filters')};
		CREATE TABLE {$this->getTable('ids_events_filters')} (
		`id` int(11) unsigned NOT NULL auto_increment,
		`event_id` int(11) unsigned NOT NULL,
		`impact` int default 0,
		`rule_id` int default 0,
		`description` varchar(512) default '',
		`tags` varchar(512) default '',	
		PRIMARY KEY (`id`),
		FOREIGN KEY (`event_id`) REFERENCES `{$this->getTable('b3it_ids/ids_events')}`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


$dir = Mage::getBaseDir().DS.'var'.DS.'ids';

if(!file_exists($dir))
{
    /** @noinspection MkdirRaceConditionInspection */
    mkdir($dir);
}



$installer->endSetup();
