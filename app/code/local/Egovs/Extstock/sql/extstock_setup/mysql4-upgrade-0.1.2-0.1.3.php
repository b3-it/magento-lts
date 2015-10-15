<?php
$installer = $this;

$installer->startSetup();

try {
$installer->run("ALTER TABLE extstock_sales_order DROP foreign key `extstock_sales_order_ibfk_1`;");
}catch(Exception $ex)
{
	;
}
$installer->run("ALTER table extstock_sales_order ADD FOREIGN KEY (`sales_order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE;");
$installer->endSetup();