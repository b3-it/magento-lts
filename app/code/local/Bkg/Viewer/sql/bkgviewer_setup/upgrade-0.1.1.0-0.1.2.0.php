<?php

/* @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();



if (!$installer->tableExists($installer->getTable('bkgviewer/composit_selectiontools'))) {
    $installer->run("
	  CREATE TABLE {$installer->getTable('bkgviewer/composit_selectiontools')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `layer_id` int(11) unsigned NOT NULL,
	  `pos` int(11) unsigned default 0,
	  `label` varchar(256) default '',
	  `is_default` smallint unsigned default 0,
	  `composit_id` int(11) unsigned,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`layer_id`) REFERENCES `{$this->getTable('bkgviewer/service_layer')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`composit_id`) REFERENCES `{$this->getTable('bkgviewer/composit_composit')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}



$installer->endSetup();