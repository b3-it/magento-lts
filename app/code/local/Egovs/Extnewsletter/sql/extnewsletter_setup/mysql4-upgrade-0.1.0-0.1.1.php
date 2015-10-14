<?php

$installer = $this;

$installer->startSetup();
$installer->run("Alter Table {$this->getTable('extnewsletter_subscriber')} drop FOREIGN KEY extnewsletter_subscriber_ibfk_1;");
$installer->endSetup(); 