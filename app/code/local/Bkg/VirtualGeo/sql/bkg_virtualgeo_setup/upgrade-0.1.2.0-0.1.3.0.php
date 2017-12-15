<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('virtualgeo/components_content_product')} 
  ADD readonly SMALLINT default 0,
  ADD is_checked SMALLINT default 0
  ");

$installer->endSetup();