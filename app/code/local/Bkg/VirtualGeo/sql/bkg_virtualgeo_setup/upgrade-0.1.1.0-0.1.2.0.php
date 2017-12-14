<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('virtualgeo/components_structure_entity')} 
  ADD show_layer SMALLINT default 0,
  ADD layer_id int(11) unsigned default NULL,
  ADD CONSTRAINT fk_components_structure_layer FOREIGN KEY (layer_id) REFERENCES {$installer->getTable('bkgviewer/service_layer')}(id) ON DELETE SET NULL
  ");

$installer->endSetup();