<?php
/**
  *
  * @category   	Bkg Virtualgeo
  * @package    	Bkg_Virtualgeo
  * @name       	Bkg_Virtualgeo Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('virtualgeo/components_content_entity')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_content_entity')};
			CREATE TABLE {$installer->getTable('virtualgeo/components_content_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_content_label')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_content_label')};
			CREATE TABLE {$installer->getTable('virtualgeo/components_content_label')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `store_id` smallint unsigned NOT NULL,
	  `parent_id` int(11) unsigned NOT NULL,
	  `name` varchar(512) default '',
	  `description` varchar(1024) default '',
	  `shortname` varchar(255) default '',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('virtualgeo/components_content_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_content_product')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_content_product')};
	  CREATE TABLE {$installer->getTable('virtualgeo/components_content_product')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `content_id` int(11) unsigned NOT NULL,
	  `product_id` int(10) unsigned NOT NULL,
	  `store_id` smallint unsigned NOT NULL,
	  `is_default` smallint unsigned default 0,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`content_id`) REFERENCES `{$this->getTable('virtualgeo/components_content_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


if (!$installer->tableExists($installer->getTable('virtualgeo/components_structure_entity')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_structure_entity')};
			CREATE TABLE {$installer->getTable('virtualgeo/components_structure_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_structure_label')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_structure_label')};
			CREATE TABLE {$installer->getTable('virtualgeo/components_structure_label')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `store_id` smallint unsigned NOT NULL,
	  `parent_id` int(11) unsigned NOT NULL,
	  `name` varchar(512) default '',
	  `description` varchar(1024) default '',
	  `shortname` varchar(255) default '',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('virtualgeo/components_structure_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_structure_product')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_structure_product')};
	  CREATE TABLE {$installer->getTable('virtualgeo/components_structure_product')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `structure_id` int(11) unsigned NOT NULL,
	  `product_id` int(10) unsigned NOT NULL,
	  `store_id` smallint unsigned NOT NULL,
	  `is_default` smallint unsigned default 0,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`structure_id`) REFERENCES `{$this->getTable('virtualgeo/components_structure_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_resolution_entity')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_resolution_entity')};
			CREATE TABLE {$installer->getTable('virtualgeo/components_resolution_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_resolution_label')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_resolution_label')};
			CREATE TABLE {$installer->getTable('virtualgeo/components_resolution_label')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `store_id` smallint unsigned NOT NULL,
	  `parent_id` int(11) unsigned NOT NULL,
	  `name` varchar(512) default '',
	  `description` varchar(1024) default '',
	  `shortname` varchar(255) default '',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('virtualgeo/components_resolution_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_resolution_product')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_resolution_product')};
	  CREATE TABLE {$installer->getTable('virtualgeo/components_resolution_product')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `resolution_id` int(11) unsigned NOT NULL,
	  `product_id` int(10) unsigned NOT NULL,
	  `store_id` smallint unsigned NOT NULL,
	  `is_default` smallint unsigned default 0,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`resolution_id`) REFERENCES `{$this->getTable('virtualgeo/components_resolution_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_storage_entity')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_storage_entity')};
			CREATE TABLE {$installer->getTable('virtualgeo/components_storage_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_storage_label')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_storage_label')};
			CREATE TABLE {$installer->getTable('virtualgeo/components_storage_label')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `store_id` smallint unsigned NOT NULL,
	  `parent_id` int(11) unsigned NOT NULL,
	  `name` varchar(512) default '',
	  `description` varchar(1024) default '',
	  `shortname` varchar(255) default '',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('virtualgeo/components_storage_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_storage_product')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_storage_product')};
	  CREATE TABLE {$installer->getTable('virtualgeo/components_storage_product')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `storage_id` int(11) unsigned NOT NULL,
	  `product_id` int(10) unsigned NOT NULL,
	  `store_id` smallint unsigned NOT NULL,
	  `is_default` smallint unsigned default 0,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`storage_id`) REFERENCES `{$this->getTable('virtualgeo/components_storage_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}
$installer->endSetup();
