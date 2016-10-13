<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();



$installer->run("ALTER TABLE {$this->getTable('framecontract_vendor')} ADD `claim_email` varchar(255) NOT NULL default '' ");

$installer->endSetup();