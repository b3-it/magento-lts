<?php

$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->tableColumnExists($installer->getTable('bfr_mach/history'), 'lauf')) {
	$installer->run("
			ALTER TABLE {$installer->getTable('bfr_mach/history')}
			ADD COLUMN lauf int(11) unsigned default 0;
			");
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('bfr_mach/history'), 'download_time')) {
	$installer->run("
			ALTER TABLE {$installer->getTable('bfr_mach/history')}
			ADD COLUMN download_time datetime NULL;
			");
}

$installer->endSetup(); 