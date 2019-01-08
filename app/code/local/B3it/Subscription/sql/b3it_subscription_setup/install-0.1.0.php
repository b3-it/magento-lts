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
  `period_unit` varchar(8)  default 'y',
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
	  `name` varchar(512) default '',
	  `initial_period_length` int(11) unsigned default 2,
	  `initial_period_unit` varchar(8)  default 'y',
	  `period_length` int(11) unsigned default 1,
	  `period_unit` varchar(8)  default 'y',
	  `renewal_offset` int default 0,
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

/*
if (!$installer->tableExists($installer->getTable($table."_label")))
{
	$installer->run("CREATE TABLE {$installer->getTable($table.'_label')} (
	`id` int(11) unsigned NOT NULL auto_increment,
	`store_id` smallint unsigned NOT NULL,
	`entity_id` int(11) unsigned NOT NULL,
	`label` varchar(512) default '',
	`description` varchar(1024) default '',
	`shortname` varchar(255) default '',
	PRIMARY KEY (`id`),
	FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable($table.'_entity')}`(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	)
	ENGINE=InnoDB DEFAULT CHARSET=utf8;");
}
*/

// Add new attributes
$installer->addAttribute('catalog_product', 'subscription_period', array(
    'label' => 'Subscription Period',
    'group' => 'General',
    'type' => 'text',
    'input' => 'select',
    'source' => 'b3it_subscription/entity_attribute_source_period',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'required' => 0,
    'user_defined' => 0,
    'filterable_in_search' => 0,
    'is_configurable' => 0,

));

$installer->endSetup();