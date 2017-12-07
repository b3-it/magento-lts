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

/** @var Bkg_VirtualGeo_Model_Resource_Setup $this */
$installer = $this;

$installer->startSetup();

$installer->addStoreView();

if ($installer->tableExists($installer->getTable('virtualgeo/components_format_entity'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_format_entity'), 'has_resolution'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_format_entity')} 
	  ADD COLUMN  `has_resolution` smallint unsigned default 0,
	  ADD COLUMN  `pos` int(11) unsigned default 0
	  ");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_structure_entity'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_structure_entity'), 'type'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_structure_entity')}
	ADD COLUMN  `type` varchar(128) default '',
	ADD COLUMN  `pos` int(11) unsigned default 0,
	ADD COLUMN  `layer_id` int(11) unsigned default NULL,
	ADD FOREIGN KEY (`layer_id`) REFERENCES `{$this->getTable('bkgviewer/service_layer')}`(`id`) ON DELETE SET NULL
	");

}

if ($installer->tableExists($installer->getTable('virtualgeo/components_storage_entity'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_storage_entity'), 'pos'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_storage_entity')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");

}

if ($installer->tableExists($installer->getTable('virtualgeo/components_resolution_entity'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_resolution_entity'), 'pos'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_resolution_entity')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");

}

if ($installer->tableExists($installer->getTable('virtualgeo/components_georef_entity'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_georef_entity'), 'pos'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_georef_entity')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_content_entity'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_content_entity'), 'pos'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_content_entity')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_resolution_product'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_resolution_product'), 'pos'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_resolution_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_format_product'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_format_product'), 'pos'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_format_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_georef_product'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_georef_product'), 'pos'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_georef_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_content_product'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_content_product'), 'pos'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_content_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_structure_product'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_structure_product'), 'pos'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_structure_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_storage_product'))
    && !$installer->getConnection()->tableColumnExists($installer->getTable('virtualgeo/components_storage_product'), 'pos'))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_storage_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if (!$installer->tableExists($installer->getTable('virtualgeo/components_content_category')))
{
	$installer->run("
	  -- DROP TABLE IF EXISTS {$installer->getTable('virtualgeo/components_content_category')};
	  CREATE TABLE {$installer->getTable('virtualgeo/components_content_category')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `code` varchar(128) default '',
	  `label` varchar(128) default '',
	  `pos` int(11) unsigned default 0,
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


$installer->endSetup();
