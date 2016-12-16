<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE `{$installer->getTable('sales_flat_order_address')}`  ADD `dap` varchar(255) default NULL");
$installer->run("ALTER TABLE `{$installer->getTable('sales_flat_quote_address')}`  ADD `dap` varchar(255) default NULL");




$installer->endSetup();