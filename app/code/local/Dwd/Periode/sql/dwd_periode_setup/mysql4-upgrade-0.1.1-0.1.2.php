<?php

$installer = $this;

$installer->startSetup();
if (!$installer->getConnection()->tableColumnExists($installer->getTable('periode/periode'), 'cancelation_period')) {
	$installer->run("ALTER TABLE {$this->getTable('periode/periode')} ADD cancelation_period INTEGER DEFAULT 14 ");
}
$installer->endSetup(); 
