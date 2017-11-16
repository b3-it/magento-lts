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
if (!$installer->tableExists($installer->getTable('virtualgeo/components_regionallocation')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_regionallocation')};
	CREATE TABLE {$installer->getTable('virtualgeo/components_regionallocation')} (
	  	`id` int(11) unsigned NOT NULL auto_increment,
    	`parent_id` int(11) unsigned NOT NULL,
        `rap_id` int(11) unsigned NOT NULL,
        `fee` varchar(128) default '',
        `usage` varchar(128) default '',
    
	PRIMARY KEY (`id`),
    FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE,
    FOREIGN KEY (`rap_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
   ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_georef_entity')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_georef_entity')};
	   CREATE TABLE {$installer->getTable('virtualgeo/components_georef_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `georef` varchar(128) default '',
	  `epsg_code` varchar(128) default '',
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_georef_label')))
{
	$installer->run("
 	-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_georef_label')};
	   CREATE TABLE {$installer->getTable('virtualgeo/components_georef_label')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `store_id` smallint unsigned NOT NULL,
	  `parent_id` int(11) unsigned NOT NULL,
	  `name` varchar(512) default '',
	  `description` varchar(1024) default '',
	  `shortname` varchar(255) default '',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('virtualgeo/components_georef_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_format_entity')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_format_entity')};
	   CREATE TABLE {$installer->getTable('virtualgeo/components_format_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_format_label')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_format_label')};
	   CREATE TABLE {$installer->getTable('virtualgeo/components_format_label')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `store_id` smallint unsigned NOT NULL,
	  `parent_id` int(11) unsigned NOT NULL,
	  `name` varchar(512) default '',
	  `description` varchar(1024) default '',
	  `shortname` varchar(255) default '',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('virtualgeo/components_format_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

/*
if (!$installer->getAttribute('catalog_product', 'request')) {
	$installer->addAttribute('catalog_product', 'request', array(
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
			'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
	));
}
*/
$installer->endSetup();
