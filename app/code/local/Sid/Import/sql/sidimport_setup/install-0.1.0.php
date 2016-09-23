<?php
/**
 * Sid Import
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Import
 * @name       	Sid_Import Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('sidimport/storage')))
{

	$installer->run("

	-- DROP TABLE IF EXISTS {$this->getTable('sidimport/storage')};
	CREATE TABLE {$this->getTable('import/storage')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `task` int(11) unsigned NOT NULL default 0,
	  `name` varchar(255) NOT NULL default '',
	  `sku` varchar(255) NOT NULL,
	  `status` smallint(6) NOT NULL default '0',
	  `importdata` text NOT NULL default '',
	  `created_time` datetime NULL,
	  `update_time` datetime NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

$installer->endSetup(); 