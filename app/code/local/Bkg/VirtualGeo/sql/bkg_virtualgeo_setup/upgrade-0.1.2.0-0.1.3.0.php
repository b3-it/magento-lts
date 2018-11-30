<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$tables = array();

$tables[] = 'virtualgeo/components_storage';

foreach ($tables as $table)
{
	if ($installer->tableExists($installer->getTable($table.'_product'))
			&& !$installer->getConnection()->tableColumnExists($installer->getTable($table.'_product'), 'transport_product_id'))
	{
		$installer->run("ALTER TABLE {$installer->getTable($table.'_product')}
		ADD transport_product_id int(10) unsigned NOT NULL,
		ADD CONSTRAINT `virtualgeo_components_storage_product_transport_product_ibfk_1` FOREIGN KEY (`transport_product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE
		");
	}
}


$installer->endSetup();