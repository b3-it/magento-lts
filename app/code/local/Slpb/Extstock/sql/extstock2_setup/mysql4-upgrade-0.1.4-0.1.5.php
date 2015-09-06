<?php

$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE extstock2_stock_order ADD `note` varchar(1024) default ''");

$installer->endSetup(); 