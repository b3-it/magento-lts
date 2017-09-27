<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();

// Löschen der alten Attribute für Kundengruppenzuordnung
$installer->run("DELETE FROM `eav_attribute` WHERE `backend_model` LIKE 'groupscatalog/%'");

$installer->endSetup();
