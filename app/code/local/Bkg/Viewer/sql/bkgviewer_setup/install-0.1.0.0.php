<?php
/**
  *
  * @category   	Bkg Viewer
  * @package    	Bkg_Viewer
  * @name       	Bkg_Viewer Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('bkgviewer/composit_composit')))
{
	$installer->run("
		-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/composit_composit')};
		CREATE TABLE {$installer->getTable('bkgviewer/composit_composit')} (
	  		`id` int(11) unsigned NOT NULL auto_increment,
	  		`title` varchar(255) default '',
	  		`active` smallint unsigned default 0,
	  		PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			");
}

if (!$installer->tableExists($installer->getTable('bkgviewer/composit_layer')))
{
	$installer->run("
		-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/composit_layer')};
		CREATE TABLE {$installer->getTable('bkgviewer/composit_layer')} (
	  		`id` int(11) unsigned NOT NULL auto_increment,
	  		`title` varchar(128) default '',
	  		`parent_id` int(11) unsigned,
	  		`composit_id` int(11) unsigned,
	  		`pos` smallint unsigned default 0,
	  		`service_layer` int(11) unsigned ,
	  		PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			");
}

if (!$installer->tableExists($installer->getTable('bkgviewer/service_service')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/service_service')};
	CREATE TABLE {$installer->getTable('bkgviewer/service_service')} (
	  	`id` int(11) unsigned NOT NULL auto_increment,
    	`title` varchar(255) default '',
    	`format` varchar(128) default '',
    	`url` varchar(512) default '',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('bkgviewer/service_layer')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/service_layer')};
	CREATE TABLE {$installer->getTable('bkgviewer/service_layer')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	    `title` varchar(255) default '',
	    `name` varchar(255) default '',
	    `abstract` varchar(512) default '',
	    `parent_id` int(11) unsigned,
	    `service_id` int(11) unsigned,
	    `bb_west` POINT,
	    `bb_east` POINT,
	    `bb_south` POINT,
	    `bb_north` POINT,
	    `style` varchar(255) default '',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`service_id`) REFERENCES `{$this->getTable('bkgviewer/service_service')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('bkgviewer/service_layer')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('bkgviewer/service_crs')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/service_crs')};
			CREATE TABLE {$installer->getTable('bkgviewer/service_crs')} (
			  `id` int(11) unsigned NOT NULL auto_increment,
			  `name` varchar(255) default '',
			  `layer_id` int(11) unsigned,
			  `minx` POINT,
			  `maxx` POINT,
			  `miny` POINT,
			  `maxy` POINT,
			  PRIMARY KEY (`id`),
			  FOREIGN KEY (`layer_id`) REFERENCES `{$this->getTable('bkgviewer/service_layer')}`(`id`) ON DELETE CASCADE
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
