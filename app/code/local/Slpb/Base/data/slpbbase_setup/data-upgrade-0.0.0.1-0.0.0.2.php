<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

// Setzen aller Migrations-Anpassungen für das BE

// Löschen der alten Attribute
$installer->run("DELETE FROM `eav_attribute` WHERE `backend_model` LIKE 'groupscatalog/%'");

// Default-Titel
$installer->run("UPDATE `core_config_data` SET `value` = 'Publikationen online' WHERE `scope` = 'default' AND `scope_id` = 0 AND `path` = 'design/head/default_title';");
$installer->run("UPDATE `core_config_data` SET `value` = 'Publikationen online' WHERE `scope` = 'default' AND `scope_id` = 0 AND `path` = 'design/header/welcome';");

// Änderungen für Abholshop
$installer->run("INSERT INTO `core_config_data` (`scope`, `scope_id`, `path`, `value`) VALUES ('stores', 2, 'design/head/default_title', 'Abholshop');");
$installer->run("UPDATE `core_config_data` SET `value` = 'Abholshop' WHERE `scope` = 'stores' AND `scope_id` = 2 AND `path` = 'design/header/welcome';");

// Änderungen für Briefbesteller
$installer->run("INSERT INTO `core_config_data` (`scope`, `scope_id`, `path`, `value`) VALUES ('stores', 3, 'design/head/default_title', 'Briefbestellungen');");
$installer->run("UPDATE `core_config_data` SET `value` = 'Briefbestellungen' WHERE `scope` = 'stores' AND `scope_id` = 3 AND `path` = 'design/header/welcome';");

// (c) im Footer anpassen
$installer->run("UPDATE `core_config_data` SET `value` = '© 2017 SLpB' WHERE `scope` = 'default' AND `scope_id` = 0 AND `path` = 'design/footer/copyright';");

// Default-Skin setzen
$installer->run("UPDATE `core_config_data` SET `value` = 'slpb' WHERE `scope` = 'default' AND `scope_id` = 0 AND `path` = 'design/theme/skin';");

// Anpassungen für Webshop
$installer->run("UPDATE `core_config_data` SET `value` = 'slpb' WHERE `scope` = 'stores' AND `scope_id` = 1 AND `path` = 'design/theme/skin';");
$installer->run("UPDATE `core_config_data` SET `value` = 'slpb' WHERE `scope` = 'stores' AND `scope_id` = 1 AND `path` = 'design/theme/template';");
$installer->run("UPDATE `core_config_data` SET `value` = 'slpb' WHERE `scope` = 'stores' AND `scope_id` = 1 AND `path` = 'design/theme/layout';");

// Anpassungen für Schnellformulare
$installer->run("UPDATE `core_config_data` SET `value` = 'slpb_small' WHERE `scope` = 'stores' AND `scope_id` = 2 AND `path` = 'design/theme/skin';");
$installer->run("UPDATE `core_config_data` SET `value` = 'slpb_small' WHERE `scope` = 'stores' AND `scope_id` = 3 AND `path` = 'design/theme/skin';");

// Logo-Grafiken setzen
$installer->run("UPDATE `core_config_data` SET `value` = 'images/slpb_logo.png' WHERE `scope` = 'default' AND `scope_id` = 0 AND `path` = 'design/header/logo_src';");
$installer->run("UPDATE `core_config_data` SET `value` = 'images/slpb_logo.png' WHERE `scope` = 'default' AND `scope_id` = 0 AND `path` = 'design/header/logo_src_small';");

//$installer->run("UPDATE `core_config_data` SET `value` = '' WHERE `scope` = 'default' AND `scope_id` = 0 AND `path` = '';");

$installer->endSetup();
