<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();


$installer->run("ALTER TABLE {$this->getTable('framecontract_transmit')} ADD `los_id` int default 0 ");
$installer->run("ALTER TABLE {$this->getTable('framecontract_transmit')} ADD `note` varchar(255) NOT NULL default '' ");
$installer->removeAttribute('catalog_product', 'framecontract');
$installer->endSetup();