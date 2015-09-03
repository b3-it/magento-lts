<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('dwd_abo/abo')} ADD has_tier_price int default 0");

$installer->endSetup();