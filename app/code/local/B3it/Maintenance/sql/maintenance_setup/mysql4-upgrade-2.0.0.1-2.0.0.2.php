<?php

$installer = $this;

$installer->startSetup();

$installer->run("
		ALTER TABLE {$this->getTable('maintenance_offline')} ADD `user` varchar(150) default '' 
");

$installer->endSetup();
