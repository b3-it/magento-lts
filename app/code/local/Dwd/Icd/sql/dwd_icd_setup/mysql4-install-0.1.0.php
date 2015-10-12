<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd Installer
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();


$installer->run("
DROP TABLE IF EXISTS {$this->getTable('icd_connection')};
CREATE TABLE {$this->getTable('icd_connection')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `url` varchar(1024) NOT NULL default '',
  `user` varchar(255) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('icd_account')};
	CREATE TABLE {$this->getTable('icd_account')} (
	`id` int(11) unsigned NOT NULL auto_increment,
	`login` varchar(255) NOT NULL default '',
	`password` varchar(255) NOT NULL default '',
	`customer_id` int(11) unsigned NOT NULL,
	`is_shareable` smallint(6) NOT NULL default '0',
    `connection_id` int(11) unsigned NOT NULL,
	`status` smallint(6) NOT NULL default '0',
	`created_time` datetime NULL,
	`update_time` datetime NULL,
	`sync_status` smallint(6) NOT NULL default '0',
	`error` varchar(1024) default '',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('icd_orderitem')};
	CREATE TABLE {$this->getTable('icd_orderitem')} (
	`id` int(11) unsigned NOT NULL auto_increment,
	`order_item_id` int(11) unsigned NOT NULL ,
	`order_id` int(11) unsigned NOT NULL ,
	`product_id` int(11) unsigned NOT NULL ,
	`station_id` int(11) unsigned NOT NULL ,
	`account_id` int(11) unsigned NOT NULL ,
	`application` varchar(512) NOT NULL default '',
	`application_url` varchar(1024) NOT NULL default '',
	`start_time` datetime NULL,
	`end_time` datetime NULL,
	`status` smallint(6) NOT NULL default '0',
	`created_time` datetime NULL,
	`update_time` datetime NULL,
	`sync_status` smallint(6) NOT NULL default '0',
	`error` varchar(1024) default '',
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->addAttribute('catalog_product', 'icd_connection', array(
		'label' => 'ICD Verbindung',
		'input' => 'select',
		'type' => 'int',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'searchable' => false,
		'comparable' => false,
		'source' => 'dwd_icd/source_attribute_connection',
		'default' => '0',
		'group' => 'General',
		'apply_to' => Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL,
));


$installer->addAttribute('catalog_product', 'icd_application', array(
		'label' => 'ICD Application',
		'input' => 'select',
		'type' => 'varchar',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => false,
		'required' => true,
		'is_user_defined' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'source'=>'dwd_icd/source_attribute_applications',
		'default' => '',
		//'option' => $option,
		'group' => 'General',
		'apply_to' => Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL,
));


$installer->endSetup(); 