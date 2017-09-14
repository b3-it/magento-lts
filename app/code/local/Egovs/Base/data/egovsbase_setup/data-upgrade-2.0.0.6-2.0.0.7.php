<?php
/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

// Default-Package nach "egov", wenn es "default" ist
$oldPackage = Mage::getStoreConfig('design/package/name');

// Daten, welche im Design angepasst werden sollen
// SELECT * FROM `core_config_data` WHERE `path` LIKE 'design/theme%'
$design_path = array(
    'design/theme/template',
    'design/theme/skin',
    'design/theme/layout',
    'design/theme/default',
    'design/theme/locale'
);

if ( $oldPackage == 'default') {
    $installer->setConfigData('design/package/name', 'egov');

    foreach( $design_path AS $config_path ) {
        // alle "alten" Werte löschen
        $installer->run("UPDATE `core_config_data` SET `value` = NULL WHERE `path` = '{$config_path}';");

        // neue Config setzen
        $installer->setConfigData($config_path, '');
    }

	$installer->setConfigData('design/header/logo_src', 'images/logo_sachsen.png');
	$installer->setConfigData('design/header/logo_src_small', 'images/logo_sachsen_smartphone.png');
}

$installer->endSetup();
