<?php

$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE `{$installer->getTable('sales_flat_order_item')}`  ADD `los_id` int(11) unsigned default null");
$installer->endSetup();
