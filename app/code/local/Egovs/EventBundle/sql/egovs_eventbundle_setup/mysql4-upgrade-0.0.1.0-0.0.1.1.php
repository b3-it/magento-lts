<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('eventbundle/personal_options')))
{

	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('eventbundle/personal_options')};
	CREATE TABLE {$this->getTable('eventbundle/personal_options')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `product_id` int(11) unsigned NOT NULL,
	  `name` varchar(255) NOT NULL default '',
	  `pos` smallint(5) default 0,
	  `required` smallint(5) default 0,
	  `max_length` smallint(5) default 150,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE 
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('eventbundle/personal_options_label')))
{

	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('eventbundle/personal_options_label')};
	CREATE TABLE {$this->getTable('eventbundle/personal_options_label')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `option_id` int(11) unsigned NOT NULL,
	  `label` varchar(255) default '',
	  `store_id` smallint(5) unsigned NOT NULL,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`option_id`) REFERENCES `{$this->getTable('eventbundle/personal_options')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('eventbundle/quote_options')))
{

	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('eventbundle/quote_options')};
	CREATE TABLE {$this->getTable('eventbundle/quote_options')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `option_id` int(11) unsigned NOT NULL,
	  `value` varchar(255) default '',
	  `quote_item_id` int(11) unsigned NOT NULL,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`option_id`) REFERENCES `{$this->getTable('eventbundle/personal_options')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`quote_item_id`) REFERENCES `{$this->getTable('sales/quote_item')}`(`item_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}


$installer->endSetup();