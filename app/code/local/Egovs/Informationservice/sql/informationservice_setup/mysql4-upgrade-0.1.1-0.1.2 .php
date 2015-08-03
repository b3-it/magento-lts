<?php

$installer = $this;

$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('informationservice_request')} MODIFY COLUMN `cost` DECIMAL(10,2) DEFAULT 0;");
$installer->run("ALTER TABLE {$this->getTable('informationservice_task')} MODIFY COLUMN `cost` DECIMAL(10,2) DEFAULT 0;");
$installer->endSetup(); 
