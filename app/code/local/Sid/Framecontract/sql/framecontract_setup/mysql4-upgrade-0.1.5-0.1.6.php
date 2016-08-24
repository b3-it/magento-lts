<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();



$installer->run("ALTER TABLE {$this->getTable('framecontract_vendor')} ADD `export_format` varchar(255) NOT NULL default 'plain' ");
$installer->run("ALTER TABLE {$this->getTable('framecontract_vendor')} ADD `transfer_type` varchar(255) NOT NULL default 'email' ");
$installer->endSetup();