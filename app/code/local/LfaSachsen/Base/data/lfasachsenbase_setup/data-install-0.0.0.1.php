<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

// Default-Package setzen
$installer->setConfigData('design/package/name', 'egov');

// Theme-Einstellungen setzen
$installer->setConfigData('design/theme/locale'  , '');
$installer->setConfigData('design/theme/template', 'lfa');
$installer->setConfigData('design/theme/skin'    , 'lfa');
$installer->setConfigData('design/theme/layout'  , 'lfa');
$installer->setConfigData('design/theme/default' , '');

// Design und Logo-Grafiken setzen
$installer->setConfigData('design/header/logo_src'      , 'images/logo_sachsen.png');
$installer->setConfigData('design/header/logo_src_small', 'images/logo_sachsen_smartphone.png');

$installer->endSetup();

