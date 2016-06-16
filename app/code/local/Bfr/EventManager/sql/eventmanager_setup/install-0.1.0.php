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


if (!$installer->tableExists($installer->getTable('eventmanager/lookup')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$this->getTable('eventmanager/lookup')};
			CREATE TABLE {$this->getTable('eventmanager/lookup')} (
			`lookup_id` int(11) unsigned NOT NULL auto_increment,
			`typ` smallint(6) NOT NULL default '0',
			`value` varchar(512) NOT NULL default '',
			PRIMARY KEY (`lookup_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}



if (!$installer->tableExists($installer->getTable('eventmanager/event')))
{
	$installer->run("
		-- DROP TABLE IF EXISTS {$this->getTable('eventmanager/event')};
		CREATE TABLE {$this->getTable('eventmanager/event')} (
		  `event_id` int(11) unsigned NOT NULL auto_increment,
		  `title` varchar(255) NOT NULL default '',
		  `lang_code` varchar(255) NOT NULL default '',
		  `product_id` int(11) unsigned NOT NULL,
		  `event_from` datetime default NULL,
		  `event_to` datetime default NULL,
		  `status` smallint(6) NOT NULL default '0',
		  `created_time` datetime NULL,
		  `update_time` datetime NULL,
		  PRIMARY KEY (`event_id`),
		  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('eventmanager/participant')))
{

	$installer->run("
			-- DROP TABLE IF EXISTS {$this->getTable('eventmanager/participant')};
			CREATE TABLE {$this->getTable('eventmanager/participant')} (
			`participant_id` int(11) unsigned NOT NULL auto_increment,
			`event_id`int(11) unsigned NOT NULL,
			`order_id`int(11) unsigned default NULL,
			`order_item_id` int(11) unsigned NULL,
			`prefix` varchar(50) NOT NULL default '', 
			`firstname` varchar(255) NOT NULL default '', 
			`lastname` varchar(255) NOT NULL default '', 
			`email` varchar(255) NOT NULL default '', 
			`company` varchar(255) NOT NULL default '', 
			`company2` varchar(255) NOT NULL default '', 
			`company3` varchar(255) NOT NULL default '', 
			`city` varchar(255) NOT NULL default '', 
			`street` varchar(255) NOT NULL default '', 
			`postcode` varchar(255) NOT NULL default '', 
			`note` varchar(1024) NOT NULL default '', 
			`postfix` varchar(255) NOT NULL default '', 
			`status` smallint(6) NOT NULL default '0',
			`vip` smallint(6) NOT NULL default '0',
			`online_eval` smallint(6) NOT NULL default '1',
			`internal` smallint(6) NOT NULL default '0',
			`role_id` int(11) unsigned default NULL, 
			`job_id` int(11) unsigned default NULL, 
			`created_time` datetime NULL,
			`update_time` datetime NULL,
			PRIMARY KEY (`participant_id`),
			FOREIGN KEY (`order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE,
			FOREIGN KEY (`order_item_id`) REFERENCES `{$this->getTable('sales/order_item')}`(`item_id`) ON DELETE CASCADE,
			FOREIGN KEY (`role_id`) REFERENCES `{$this->getTable('eventmanager/lookup')}`(`lookup_id`) ON DELETE SET NULL,
			FOREIGN KEY (`job_id`) REFERENCES `{$this->getTable('eventmanager/lookup')}`(`lookup_id`) ON DELETE SET NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}


if (!$installer->tableExists($installer->getTable('eventmanager/participant_attribute')))
{

	$installer->run("
			-- DROP TABLE IF EXISTS {$this->getTable('eventmanager/participant_attribute')};
			CREATE TABLE {$this->getTable('eventmanager/participant_attribute')} (
			`id` int(11) unsigned NOT NULL auto_increment,
			`participant_id` int(11) unsigned NOT NULL,
			`lookup_id` int(11) unsigned NOT NULL,
			PRIMARY KEY (`id`),
			FOREIGN KEY (`lookup_id`) REFERENCES `{$this->getTable('eventmanager/lookup')}`(`lookup_id`) ON DELETE CASCADE,
			FOREIGN KEY (`participant_id`) REFERENCES `{$this->getTable('eventmanager/participant')}`(`participant_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}



if (!$installer->tableExists($installer->getTable('eventmanager/translate')))
{

	$installer->run("
			-- DROP TABLE IF EXISTS {$this->getTable('eventmanager/translate')};
			CREATE TABLE {$this->getTable('eventmanager/translate')} (
			`translate_id` int(11) unsigned NOT NULL auto_increment,
			`field` varchar(512) NOT NULL default '',
			`source` varchar(512) NOT NULL default '',
			`dest` varchar(512) NOT NULL default '',
			`lang_code` varchar(255) NOT NULL default '',
			PRIMARY KEY (`translate_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}




if (!$installer->getAttribute('catalog_product', 'event_role')) {
	$installer->addAttribute('catalog_product', 'event_role', array(
			'label' => 'With Request',
			'input' => 'select',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => false,
			//'required' => true,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'source'    => 'eav/entity_attribute_source_boolean',
			'default' => '1',
			//'option' => $option,
			'group' => 'General',
			'apply_to' => Mage_Catalog_Model_Product_Type::TYPE_SIMPLE, Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL,
	));
}



$installer->endSetup(); 