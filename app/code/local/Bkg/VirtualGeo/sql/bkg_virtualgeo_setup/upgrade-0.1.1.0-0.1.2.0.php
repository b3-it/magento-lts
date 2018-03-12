<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tables = array();
$tables[] = 'virtualgeo/components_georef';
$tables[] = 'virtualgeo/components_format';
$tables[] = 'virtualgeo/components_content';
$tables[] = 'virtualgeo/components_structure';
$tables[] = 'virtualgeo/components_resolution';
$tables[] = 'virtualgeo/components_storage';

foreach ($tables as $table)
{
	if ($installer->tableExists($installer->getTable($table.'_product'))
			&& !$installer->getConnection()->tableColumnExists($installer->getTable($table.'_product'), 'is_visible_only_in_admin'))
	{
		$installer->run("ALTER TABLE {$installer->getTable($table.'_product')}
		ADD is_visible_only_in_admin SMALLINT default 0
		");
	}
}


$installer->endSetup();