<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$_cmsTable = $installer->getTable('cms/page');
if ($installer->tableExists($_cmsTable))
{
	$installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'two_columns_right';");
	$installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'three_columns';");
}

$installer->endSetup();