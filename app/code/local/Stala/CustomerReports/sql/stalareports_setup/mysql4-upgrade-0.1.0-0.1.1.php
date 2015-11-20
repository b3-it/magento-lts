<?php

$installer = $this;

$installer->startSetup();

$installer->run("TRUNCATE TABLE {$this->getTable('sales/invoiced_aggregated_order')};");
$installer->run("ALTER TABLE {$this->getTable('sales/invoiced_aggregated_order')}
	DROP INDEX `UNQ_SALES_INVOICED_AGGREGATED_ORDER_PERIOD_STORE_ID_ORDER_STATUS` ,
	ADD UNIQUE INDEX `UNQ_SALES_INVOICED_AGGREGATED_ORDER_PERIOD_STORE_ID_ORDER_STATUS` 
	(`period` ASC, `store_id` ASC, `order_status` ASC, `customer_group_id` ASC);");


$installer->run("TRUNCATE TABLE {$this->getTable('sales/invoiced_aggregated')};");
$installer->run("ALTER TABLE {$this->getTable('sales/invoiced_aggregated')} 
	DROP INDEX `UNQ_SALES_INVOICED_AGGREGATED_PERIOD_STORE_ID_ORDER_STATUS` ,
	ADD UNIQUE INDEX `UNQ_SALES_INVOICED_AGGREGATED_PERIOD_STORE_ID_ORDER_STATUS` 
	(`period` ASC, `store_id` ASC, `order_status` ASC, `customer_group_id` ASC);");

$installer->endSetup(); 