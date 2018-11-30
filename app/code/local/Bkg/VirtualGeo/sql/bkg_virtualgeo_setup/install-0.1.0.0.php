<?php
/**
  *
  * @category   	Bkg
  * @package    	Bkg_VirtualGeo
  * @name       	Bkg_VirtualGeo Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
/** @var $this Bkg_VirtualGeo_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('virtualgeo/components_regionallocation')))
{
	$installer->run("
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
	   CREATE TABLE {$installer->getTable('virtualgeo/components_georef_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  `epsg_code` varchar(128) default '',
      `proj4` varchar(512) default '',
	  `pos` int(11) unsigned default 0,
	  UNIQUE KEY ìdx_georef_code (`code`), 
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}


if (!$installer->tableExists($installer->getTable('virtualgeo/components_content_category')))
{
    $installer->run("
	  CREATE TABLE {$installer->getTable('virtualgeo/components_content_category')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `label` varchar(128) default '',
	  `pos` int(11) unsigned default 0,
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_content_entity')))
{
    $installer->run("
	  CREATE TABLE {$installer->getTable('virtualgeo/components_content_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  `category_id` int(11) unsigned default NULL,
	  `pos` int(11) unsigned default 0,
	  INDEX ìdx_content_code (`code`), 
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`category_id`) REFERENCES `{$this->getTable('virtualgeo/components_content_category')}`(`id`) ON DELETE SET NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_format_entity')))
{
    $installer->run("
	   CREATE TABLE {$installer->getTable('virtualgeo/components_format_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  `has_resolution` smallint unsigned default 0,
	  `pos` int(11) unsigned default 0,
	  CONSTRAINT UNIQUE INDEX ìdx_format_code (`code`), 
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_resolution_entity')))
{
    $installer->run("
	CREATE TABLE {$installer->getTable('virtualgeo/components_resolution_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  `pos` int(11) unsigned default 0,
	  INDEX ìdx_resolution_code (`code`), 
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_structure_category')))
{
    $installer->run("
	  CREATE TABLE {$installer->getTable('virtualgeo/components_structure_category')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `label` varchar(128) default '',
	  `code` varchar(128) default '',
	  `pos` int(11) unsigned default 0,
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_structure_entity')))
{
    $installer->run("
		CREATE TABLE {$installer->getTable('virtualgeo/components_structure_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  `type` varchar(128) default '',
	  `pos` int(11) unsigned default 0,
	  `category_id` int(11) unsigned default NULL,
	  INDEX ìdx_structure_code (`code`), 
  	  show_layer SMALLINT default 0,
      service_id int(11) unsigned default NULL,
      FOREIGN KEY (`category_id`) REFERENCES `{$this->getTable('virtualgeo/components_structure_category')}`(`id`) ON DELETE SET NULL
  	  CONSTRAINT fk_components_structure_service FOREIGN KEY (service_id) REFERENCES {$installer->getTable('bkgviewer/service_service')}(id) ON DELETE SET NULL,
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_storage_entity')))
{
    $installer->run("
	   CREATE TABLE {$installer->getTable('virtualgeo/components_storage_entity')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  `pos` int(11) unsigned default 0,
	  `max_mb` int(11) unsigned default 0,
	  CONSTRAINT UNIQUE INDEX ìdx_storage_code (`code`), 
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}



$tables = array();
$tables[] = 'virtualgeo/components_georef';
$tables[] = 'virtualgeo/components_format';
$tables[] = 'virtualgeo/components_content';
$tables[] = 'virtualgeo/components_structure';
$tables[] = 'virtualgeo/components_resolution';
$tables[] = 'virtualgeo/components_storage';

foreach ($tables as $table)
{

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
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_content_product'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_content_product'), 'parent_node_id'))
{
    $installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_content_product')}
	ADD COLUMN  `parent_node_id` int(11) unsigned default NULL,
	ADD readonly SMALLINT default 0,
    ADD is_checked SMALLINT default 0,
	ADD CONSTRAINT fk_components_content_product_parent FOREIGN KEY (parent_node_id) REFERENCES {$installer->getTable('virtualgeo/components_content_product')}(id)
	ON UPDATE CASCADE ON DELETE CASCADE
	");
}

$installer->addStoreView();

$installer->endSetup();
