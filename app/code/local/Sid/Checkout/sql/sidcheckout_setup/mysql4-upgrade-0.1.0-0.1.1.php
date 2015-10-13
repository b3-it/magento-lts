<?php

$installer = $this;
$installer->startSetup();
$installer->run("ALTER TABLE `{$installer->getTable('sales_flat_order')}`  ADD `framecontract` int(11) unsigned default null");
$installer->endSetup();
