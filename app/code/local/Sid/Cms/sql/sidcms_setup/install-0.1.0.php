<?php
/**
 * Sid Cms
 * 
 * 
 * @category   	Sid
 * @package    	Sid_Cms
 * @name       	Sid_Cms Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();
if ($installer->tableExists($installer->getTable('cms/page')))
{
	$installer->run("ALTER TABLE {$this->getTable('cms/page')} ADD `activate_time` datetime NULL;");
	$installer->run("ALTER TABLE {$this->getTable('cms/page')} ADD `deactivate_time` datetime NULL;");
	$installer->run("ALTER TABLE {$this->getTable('cms/page')} ADD `customergroups_show` varchar(255) default '-1';");
	
}


if (!$installer->tableExists($installer->getTable('sidcms/navigation')))
{
	$installer->run("
		CREATE TABLE {$this->getTable('sidcms/navigation')} (
		  `id` int(11) unsigned NOT NULL auto_increment,
		  `store_id` smallint unsigned NOT NULL,
		  `title` varchar(255) NOT NULL default '',
		  `created_time` datetime NULL,
		  `update_time` datetime NULL,
		  PRIMARY KEY (`id`),
		  FOREIGN KEY (`store_id`) REFERENCES {$this->getTable('core/store')} (store_id) ON DELETE CASCADE
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('sidcms/navigation_node')))
{
	$installer->run("
			CREATE TABLE {$this->getTable('sidcms/navigation_node')} (
			`id` int(11) unsigned NOT NULL auto_increment,
			`parent_id` int(11) unsigned,
			`page_id` smallint(6) default NULL,
			`navi_id` int(11) unsigned NOT NULL,
			`pos` smallint(6) unsigned default 0,
			`label` varchar(255) NOT NULL default '',
			`type` varchar(10) NOT NULL default 'default',
			`created_time` datetime NULL,
			`update_time` datetime NULL,
			PRIMARY KEY (`id`),
			FOREIGN KEY (`navi_id`) REFERENCES {$this->getTable('sidcms/navigation')} (id) ON DELETE CASCADE,
			FOREIGN KEY (`parent_id`) REFERENCES {$this->getTable('sidcms/navigation_node')} (id) ON DELETE CASCADE,
			FOREIGN KEY (`page_id`) REFERENCES {$this->getTable('cms/page')} (page_id) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}






$installer->endSetup(); 