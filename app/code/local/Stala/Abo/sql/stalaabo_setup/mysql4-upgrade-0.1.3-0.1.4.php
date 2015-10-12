<?php

$installer = $this;

$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('stala_abo_delivered')} ADD Column freecopies varchar(512) default ''");


$installer->endSetup(); 