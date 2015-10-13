<?php

$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('stationen/stationen')} ADD UNIQUE INDEX(stationskennung, messnetz)");
$installer->run("ALTER TABLE {$this->getTable('stationen_set_relation')} ADD `stationen_id` int(11) unsigned NOT NULL");



$installer->endSetup(); 