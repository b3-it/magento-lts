<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();

// Default-Package nach "egov", wenn es "default" ist
$oldPackage = Mage::getStoreConfig('design/package/name');

// Neue Design-Packages
$newPackages = array('egov', 'dwd', 'bfr', 'adlerwarte');

// Daten, welche im Design angepasst werden sollen
// SELECT * FROM `core_config_data` WHERE `path` LIKE 'design/theme%'
$design_path = array(
    'design/theme/template',
    'design/theme/skin',
    'design/theme/layout',
    'design/theme/default',
    'design/theme/locale'
);

if ( ($oldPackage == 'default') AND !in_array($oldPackage, $newPackages) ) {
    // eigene Designs löschen
    $installer->run("DELETE FROM `core_config_data` WHERE `path` = 'design/package/name' AND `scope_id` > 0");
    
    // Default-Package setzen
    $installer->setConfigData('design/package/name', 'egov');

    foreach( $design_path AS $config_path ) {
        // alle "alten" Werte löschen
        $installer->run("DELETE FROM `core_config_data` WHERE `path` = '{$config_path}' AND `scope_id` > 0;");

        // neue Config setzen
        $installer->setConfigData($config_path, '');
    }
    
    // Spezielle Designs löschen
    $installer->run("DELETE FROM `design_change`");
    
    // alte Kategorie-Designs löschen
    $installer->run("DELETE FROM `catalog_category_entity_varchar` WHERE `value` LIKE 'default/%';");
    
	$installer->setConfigData('design/header/logo_src', 'images/logo_sachsen.png');
	$installer->setConfigData('design/header/logo_src_small', 'images/logo_sachsen_smartphone.png');
}

// DEMO-Hinweis löschen
$installer->run("DELETE FROM `core_config_data` WHERE `path` = 'design/head/demonotice' AND `scope_id` > 0");

// Seiten-Layout auf 2-Spaltig-Links setzen
$_cmsTable = $installer->getTable('cms/page');
if ($installer->tableExists($_cmsTable))
{
    $installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'two_columns_right';");
    $installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'three_columns';");
}


$installer->endSetup();
