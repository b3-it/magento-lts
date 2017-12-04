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

$installer->addStoreView();

if ($installer->tableExists($installer->getTable('virtualgeo/components_format_entity')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_format_entity')} 
	  ADD COLUMN  `has_resolution` smallint unsigned default 0,
	  ADD COLUMN  `pos` int(11) unsigned default 0
	  ");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_structure_entity')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_structure_entity')}
	ADD COLUMN  `type` varchar(128) default '',
	ADD COLUMN  `pos` int(11) unsigned default 0,
	ADD COLUMN  `layer_id` int(11) unsigned default NULL,
	ADD FOREIGN KEY (`layer_id`) REFERENCES `{$this->getTable('bkgviewer/service_layer')}`(`id`) ON DELETE SET NULL
	");

}

if ($installer->tableExists($installer->getTable('virtualgeo/components_storage_entity')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_storage_entity')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");

}

if ($installer->tableExists($installer->getTable('virtualgeo/components_resolution_entity')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_resolution_entity')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");

}

if ($installer->tableExists($installer->getTable('virtualgeo/components_georef_entity')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_georef_entity')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_content_entity')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_content_entity')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_resolution_product')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_resolution_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_format_product')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_format_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_georef_product')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_georef_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_content_product')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_content_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_structure_product')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_structure_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_storage_product')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_storage_product')}
	ADD COLUMN  `pos` int(11) unsigned default 0
	");
}

$installer->endSetup();
