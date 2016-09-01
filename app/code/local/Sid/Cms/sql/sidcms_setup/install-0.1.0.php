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
	//$installer->run("ALTER TABLE {$this->getTable('cms/page')} ADD `activate_time` datetime NULL;");
	//$installer->run("ALTER TABLE {$this->getTable('cms/page')} ADD `deactivate_time` datetime NULL;");
	
}


if (!$installer->tableExists($installer->getTable('sidcms/navigation')))
{
	$installer->run("
		CREATE TABLE {$this->getTable('sidcms/navigation')} (
		  `id` int(11) unsigned NOT NULL auto_increment,
		  `store_id` smallint unsigned NOT NULL,
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
			`navi_id` int(11) unsigned NOT NULL,
			`label` varchar(255) NOT NULL default '',
			`created_time` datetime NULL,
			`update_time` datetime NULL,
			PRIMARY KEY (`id`),
			FOREIGN KEY (`navi_id`) REFERENCES {$this->getTable('sidcms/navigation')} (id) ON DELETE CASCADE,
			FOREIGN KEY (`parent_id`) REFERENCES {$this->getTable('sidcms/navigation_node')} (id) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}


if (!$installer->tableExists($installer->getTable('sidcms/navigation_page')))
{
	$installer->run("
			CREATE TABLE {$this->getTable('sidcms/navigation_page')} (
			`id` int(11) unsigned NOT NULL auto_increment,
			`page_id` int(11) unsigned NOT NULL,
			`pos` int(11) unsigned default 0,			
			`created_time` datetime NULL,
			`update_time` datetime NULL,
			PRIMARY KEY (`id`),
			FOREIGN KEY (`page_id`) REFERENCES {$this->getTable('sidcms/navigation_page')} (id) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}



$installer->endSetup(); 