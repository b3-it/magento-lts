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

/* @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();


if (!$installer->tableExists($installer->getTable('bkgviewer/service_tile_system')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/service_tile_system')};
	CREATE TABLE {$installer->getTable('bkgviewer/service_tile_system')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `name` varchar(255) default '',
	  `ident` varchar(255) default '',
	  `crs` varchar(255) default '',
	  `filename` varchar(255) default '',
	  `url` varchar(255) default '',
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('bkgviewer/service_tile')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/service_tile')};
	CREATE TABLE {$installer->getTable('bkgviewer/service_tile')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `ident` varchar(255) default '',
	  `shape` POLYGON,
	  `area` int(11) default 0,
	  `system_id` int(11) unsigned,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`system_id`) REFERENCES `{$this->getTable('bkgviewer/service_tile_system')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('bkgviewer/service_vg_group')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/service_vg_group')};
	CREATE TABLE {$installer->getTable('bkgviewer/service_vg_group')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `name` varchar(255) default '',
	  `filename` varchar(255) default '',
	  `ident` varchar(255) default '',
	  `crs` varchar(255) default '',
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}


if (!$installer->tableExists($installer->getTable('bkgviewer/service_vg')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/service_vg')};
	CREATE TABLE {$installer->getTable('bkgviewer/service_vg')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `name` varchar(255) default '',
	  `ident` varchar(255) default '',
	  `crs` varchar(255) default '',
	  `group_id` int(11) unsigned NOT NULL,
	  `shape` MULTIPOLYGON,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`group_id`) REFERENCES `{$this->getTable('bkgviewer/service_vg_group')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}


if (!$installer->tableExists($installer->getTable('bkgviewer/composit_composit')))
{
	$installer->run("
		-- DROP TABLE IF EXISTS {$installer->getTable('bkgviewer/composit_composit')};
		CREATE TABLE {$installer->getTable('bkgviewer/composit_composit')} (
	  		`id` int(11) unsigned NOT NULL auto_increment,
	  		`title` varchar(255) default '',
	  		`active` smallint unsigned default 0,
	  		`tile_system` varchar(255) default '',
	  		`vg_system` varchar(255) default '',
	  		`betroffenheit` varchar(512) default '',
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
	  		`type` varchar(45) default '',
	  		`parent_id` int(11) unsigned,
	  		`composit_id` int(11) unsigned,
	  		`pos` smallint unsigned default 0,
	  		`visual_pos` smallint unsigned default 0,
	  		`service_layer_id` int(11) unsigned ,
	  		PRIMARY KEY (`id`),
	  		 FOREIGN KEY (`composit_id`) REFERENCES `{$this->getTable('bkgviewer/composit_composit')}`(`id`) ON DELETE CASCADE
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
    	`url_featureinfo` varchar(512) default '',
    	`url_map` varchar(512) default '',
    	`type` varchar(56) default 'wms',
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
	    `bb_west` varchar(128),
	    `bb_east` varchar(128),
	    `bb_south` varchar(128),
	    `bb_north` varchar(128),
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
			  `min` POINT,
			  `max` POINT,
			  PRIMARY KEY (`id`),
			  FOREIGN KEY (`layer_id`) REFERENCES `{$this->getTable('bkgviewer/service_layer')}`(`id`) ON DELETE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			");
}



if (!$installer->getAttribute('catalog_product', 'geocomposit')) {
	$installer->addAttribute('catalog_product', 'geocomposit', array(
			'label' => 'Geo Composit',
			'input' => 'select',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => true,
			//'required' => true,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'source'    => 'bkgviewer/entity_attribute_source_geocomposit',
			'default' => '1',
			//'option' => $option,
			'group' => 'General',
			//'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
	));
}

$installer->endSetup();
