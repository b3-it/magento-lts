<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

// Logo-Grafiken setzen
$installer->setConfigData('design/header/logo_src', 'images/logo_lhdd.png');
$installer->setConfigData('design/header/logo_src_small', 'images/logo_lhdd_smartphone.png');

// Theme-Einstellungen zurücksetzen
$installer->setConfigData('design/theme/locale', '');
$installer->setConfigData('design/theme/template', '');
$installer->setConfigData('design/theme/skin', '');
$installer->setConfigData('design/theme/layout', '');
$installer->setConfigData('design/theme/default', '');

// Default-Package setzen
$installer->setConfigData('design/package/name', 'lhdd');


$installer->endSetup();