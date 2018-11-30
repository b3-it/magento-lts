<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */

$installer = $this;

$installer->startSetup();

// Default-Package setzen
$installer->setConfigData('design/package/name', 'bkg');

// Design und Logo-Grafiken setzen
$installer->setConfigData('design/header/logo_src'      , 'images/logo.svg');
$installer->setConfigData('design/header/logo_src_small', 'images/bkg_logo.png');

$installer->endSetup();
