<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

$_cmsTable = $installer->getTable('cms/page');
if ($installer->tableExists($_cmsTable))
{
	$installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'two_columns_right';");
	$installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'three_columns';");
}

// Logo-Grafiken setzen
$installer->setConfigData('design/header/logo_src', 'images/logo_sachsen.png');
$installer->setConfigData('design/header/logo_src_small', 'images/logo_sachsen_smartphone.png');

// Theme-Design anpassen
$installer->setConfigData('design/theme/locale', 'gitterladen');
$installer->setConfigData('design/theme/template', '');
$installer->setConfigData('design/theme/skin', 'gitterladen');
$installer->setConfigData('design/theme/layout', 'gitterladen');
$installer->setConfigData('design/theme/default', '');


$installer->endSetup();