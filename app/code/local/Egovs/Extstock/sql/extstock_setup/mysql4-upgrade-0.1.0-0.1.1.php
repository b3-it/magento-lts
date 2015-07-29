<?php
$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('extstock_sales_order')};
CREATE TABLE {$this->getTable('extstock_sales_order')} (
`extstock_sales_order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`extstock_id` int(10) UNSIGNED NOT NULL ,
`sales_order_id` int(10) UNSIGNED NOT NULL ,
`qty_ordered` int(10) UNSIGNED NOT NULL ,
FOREIGN KEY (`sales_order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE,
FOREIGN KEY (`extstock_id`) REFERENCES `extstock`(`extstock_id`) ON DELETE CASCADE,
PRIMARY KEY (`extstock_sales_order_id` ) ,
INDEX ( `sales_order_id` ) ,
INDEX ( `extstock_id` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");

$installer->endSetup();