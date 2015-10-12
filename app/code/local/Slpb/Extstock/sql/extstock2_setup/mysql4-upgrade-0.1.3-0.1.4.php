<?php

$installer = $this;

$installer->startSetup();


$installer->run("ALTER TABLE extstock2_stock_journal ADD `qty_ordered` int default 0");
$installer->run("ALTER TABLE extstock2_stock_order ADD `desired_date` datetime default null");





$installer->endSetup(); 