<?php
/**
 * B3it Subscription
 *
 *
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('b3it_subscription/subscription')))
{
$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('b3it_subscription/subscription')};
CREATE TABLE {$this->getTable('b3it_subscription/subscription')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `first_order_id` int(11) unsigned default NULL,
  `first_orderitem_id` int(11) unsigned default NULL,
  `current_order_id` int(11) unsigned default NULL,
  `current_orderitem_id` int(11) unsigned default NULL,
  `product_id` int(11) unsigned default NULL,
  `counter` smallint(6) unsigned default 0,
  `renewal_status` smallint(6) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `start_date` datetime NULL,
  `stop_date` datetime NULL,
  `renewal_date` datetime NULL,
  `period_length` int default 365,
  `renewal_offset` int default 0,
  `order_group` varchar(128) default '',
  
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");
}

$table = 'b3it_subscription/period';

if (!$installer->tableExists($installer->getTable($table.'_entity')))
{
	$installer->run("
			CREATE TABLE {$installer->getTable($table.'_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `pos` int(11) unsigned default 0,
	  `period_length` int(11) unsigned default 365,
	  `renewal_offset` int default 0,
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


if (!$installer->tableExists($installer->getTable($table."_label")))
{
	$installer->run("CREATE TABLE {$installer->getTable($table.'_label')} (
	`id` int(11) unsigned NOT NULL auto_increment,
	`store_id` smallint unsigned NOT NULL,
	`entity_id` int(11) unsigned NOT NULL,
	`name` varchar(512) default '',
	`description` varchar(1024) default '',
	`shortname` varchar(255) default '',
	PRIMARY KEY (`id`),
	FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable($table.'_entity')}`(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	)
	ENGINE=InnoDB DEFAULT CHARSET=utf8;");
}

if (!$installer->tableExists($installer->getTable($table.'_product'))) {
	$installer->run("

	  CREATE TABLE {$installer->getTable($table.'_product')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `entity_id` int(11) unsigned NOT NULL,
	  `product_id` int(10) unsigned NOT NULL,
	  `store_id` smallint unsigned NOT NULL,
	  `pos` int(11) unsigned default 0,
	  `is_default` smallint unsigned default 0,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable($table.'_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


$installer->endSetup();