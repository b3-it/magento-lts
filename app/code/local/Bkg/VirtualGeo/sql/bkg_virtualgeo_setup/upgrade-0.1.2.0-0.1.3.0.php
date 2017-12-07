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

$installer = $this;

$installer->startSetup();

$installer->addStoreView();


if ($installer->tableExists($installer->getTable('virtualgeo/components_georef_entity')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_georef_entity')}
	CHANGE  `georef` `code` varchar(128) default '';
	");
}



$tables = array();
$tables[] = array('col'=>'resolution_id', 'table' => 'virtualgeo/components_resolution_product');
$tables[] = array('col'=>'format_id', 'table' =>  'virtualgeo/components_format_product');
$tables[] = array('col'=>'georef_id', 'table' =>  'virtualgeo/components_georef_product');
$tables[] = array('col'=>'content_id', 'table' =>  'virtualgeo/components_content_product');
$tables[] = array('col'=>'structure_id', 'table' =>  'virtualgeo/components_structure_product');
$tables[] = array('col'=>'storage_id', 'table' =>  'virtualgeo/components_storage_product');

foreach($tables as $table)
{

	if ($installer->tableExists($installer->getTable($table['table']))
        && !$installer->getConnection()->tableColumnExists($installer->getTable($table['table']), 'entity_id'))
	{
		$installer->run("ALTER TABLE {$installer->getTable($table['table'])}
		CHANGE {$table['col']} `entity_id`  int(11) unsigned NOT NULL;
		");
	}
}

if ($installer->tableExists($installer->getTable('virtualgeo/components_content_product')))
{
	$installer->run("ALTER TABLE {$installer->getTable('virtualgeo/components_content_product')}
	ADD COLUMN  `parent_node_id` int(11) unsigned default NULL,
	ADD CONSTRAINT fk_components_content_product_parent FOREIGN KEY (parent_node_id) REFERENCES {$installer->getTable('virtualgeo/components_content_product')}(id)
	ON UPDATE CASCADE ON DELETE CASCADE
	");
}


$installer->endSetup();
