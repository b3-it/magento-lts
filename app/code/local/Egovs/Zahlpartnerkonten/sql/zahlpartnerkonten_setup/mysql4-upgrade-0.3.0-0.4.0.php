<?php

$installer = $this;

$installer->startSetup();
$installer->run("ALTER TABLE {$this->getTable('zahlpartnerkonten_pool')} ADD UNIQUE(kassenzeichen)");

$installer->endSetup(); 