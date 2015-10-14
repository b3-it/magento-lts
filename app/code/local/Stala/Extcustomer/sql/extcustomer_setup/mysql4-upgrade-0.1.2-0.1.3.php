<?php
/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
	ALTER TABLE {$this->getTable('extcustomer_sales_discount')} DROP FOREIGN KEY `FK_extcustomer_sales_quote_item_id`;
");

$installer->endSetup(); 