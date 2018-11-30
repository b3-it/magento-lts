<?php

/* @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();



if ($installer->tableExists($installer->getTable('bkgviewer/composit_layer'))) {
	$sql = "Alter TABLE {$installer->getTable('bkgviewer/composit_layer')} 
	  	ADD permanent SMALLINT default 0,
	  	ADD is_checked SMALLINT default 0,
	  	ADD CONSTRAINT `bkg_viewer_composit_layer_parent` FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('bkgviewer/composit_layer')}` (`id`) ON DELETE CASCADE";
	//die($sql);
    $installer->run($sql);
}



$installer->endSetup();