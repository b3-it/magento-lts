<?php

$installer = $this;

$installer->startSetup();
$installer->run("
	ALTER TABLE {$this->getTable('zahlpartnerkonten_pool')} ADD email varchar(255) NOT NULL default ''
	");

$installer->endSetup(); 