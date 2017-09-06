<?php
/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

// Löschen der alten Attribute für Kundengruppenzuordnung
$installer->run("DELETE FROM `eav_attribute` WHERE `backend_model` LIKE 'groupscatalog/%'");

$installer->endSetup();
