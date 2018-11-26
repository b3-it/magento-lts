<?php

$installer = $this;

$installer->startSetup();

$columnName = 'store_group';
$table = $installer->getTable('sales/order_item');
if ($installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
    $installer->run("CREATE INDEX {$table}_{$columnName}_idx ON {$table}({$columnName})");
}



$installer->endSetup(); 