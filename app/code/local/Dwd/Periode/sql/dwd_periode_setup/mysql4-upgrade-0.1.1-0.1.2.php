<?php

$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('periode/periode')} ADD cancelation_period INTEGER DEFAULT 14 ");
$installer->endSetup(); 
