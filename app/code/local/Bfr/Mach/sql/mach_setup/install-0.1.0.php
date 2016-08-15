<?php
/**
 * Bfr Mach
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('bfr_mach/history')))
{

	$installer->run("

	-- DROP TABLE IF EXISTS {$this->getTable('bfr_mach/history')};
	CREATE TABLE {$this->getTable('bfr_mach/history')} (
	  `mach_history_id` int(11) unsigned NOT NULL auto_increment,
	  `user` varchar(255) NOT NULL default '',
	  `order_id`int(11) unsigned default NULL,
	  `export_type` smallint(6) NOT NULL default 0,
	  `deprecated` smallint(6) NOT NULL default 0,
	  `created_time` datetime NULL,
	  `update_time` datetime NULL,
	  PRIMARY KEY (`mach_history_id`),
	  FOREIGN KEY (`order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}


$installer->endSetup(); 