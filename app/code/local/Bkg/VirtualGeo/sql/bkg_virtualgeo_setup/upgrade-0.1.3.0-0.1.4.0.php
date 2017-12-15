<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('virtualgeo/components_structure_entity')} 
  ADD service_id int(11) unsigned default NULL,
  ADD CONSTRAINT fk_components_structure_service FOREIGN KEY (service_id) REFERENCES {$installer->getTable('bkgviewer/service_service')}(id) ON DELETE SET NULL
  ");

$installer->endSetup();