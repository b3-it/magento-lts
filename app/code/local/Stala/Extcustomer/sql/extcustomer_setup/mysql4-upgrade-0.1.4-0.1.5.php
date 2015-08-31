<?php
/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), 'stala_freecopies')) {
	$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), 'stala_freecopies', 'decimal(12,4)');
}
$installer->endSetup(); 