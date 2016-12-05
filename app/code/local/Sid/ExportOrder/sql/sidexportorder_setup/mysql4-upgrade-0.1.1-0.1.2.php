<?php

$installer = $this;

$installer->startSetup();



if ($installer->tableExists($installer->getTable('exportorder/link')))
{
	$installer->run("ALTER TABLE {$this->getTable('exportorder/link')} ADD `link_status` int unsigned DEFAULT 1");

}




$installer->endSetup(); 