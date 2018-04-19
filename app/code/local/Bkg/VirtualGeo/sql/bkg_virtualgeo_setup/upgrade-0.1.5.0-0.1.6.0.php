<?php

/* @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$component = 'virtualgeo/components_accounting';

if (!$installer->tableExists($installer->getTable($component.'_entity')))
{
    $installer->run("
	   CREATE TABLE {$installer->getTable($component.'_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  `type` varchar(128) default '',
	  `pos` int(11) unsigned default 0,
	  UNIQUE KEY ìdx_georef_code (`code`), 
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable($component."_label")))
{
    $installer->run("CREATE TABLE {$installer->getTable($component.'_label')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `store_id` smallint unsigned NOT NULL,
	  `entity_id` int(11) unsigned NOT NULL,
	  `name` varchar(512) default '',
	  `description` varchar(1024) default '',
	  `shortname` varchar(255) default '',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable($component.'_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) 
	  ENGINE=InnoDB DEFAULT CHARSET=utf8;");
}

$installer->endSetup();