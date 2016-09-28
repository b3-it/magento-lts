<?php

$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE `{$installer->getTable('sales_flat_order_item')}`  ADD `vergabenummer` varchar(255) default '' ");
$installer->endSetup();
