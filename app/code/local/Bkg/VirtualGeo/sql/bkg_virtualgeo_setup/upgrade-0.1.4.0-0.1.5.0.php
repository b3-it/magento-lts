<?php

/* @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$table = $installer->getTable("virtualgeo/service_geometry");
$georef = $installer->getTable('virtualgeo/components_georef_entity');
$service = $installer->getTable('bkgviewer/service_layer');

if (!$installer->tableExists($table)) {
    // need to use geometry there, because it can be different types
    
    $installer->run("CREATE TABLE {$table} (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `layer_id` int(11) unsigned NOT NULL,
  `crs_id` int(11) unsigned NOT NULL,
  `shape` geometry DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `layer_id` (`layer_id`),
  KEY `crs_id` (`crs_id`),
  CONSTRAINT FOREIGN KEY (`layer_id`) REFERENCES `{$service}` (`id`) ON DELETE CASCADE,
  CONSTRAINT FOREIGN KEY (`crs_id`) REFERENCES `{$georef}` (`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
}

$installer->endSetup();