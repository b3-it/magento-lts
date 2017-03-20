<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();


if (!$installer->tableExists($installer->getTable('configcompare/configcompare')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$this->getTable('configcompare/configcompare')};
			CREATE TABLE {$this->getTable('configcompare/configcompare')} (
			`id` int(11) unsigned NOT NULL auto_increment,
			`type` varchar(512) NOT NULL default '',
			`value` text NOT NULL default '',
			`created_time` timestamp default NOW(),
			PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}



$installer->endSetup(); 