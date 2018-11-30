<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

/* Module-Check -- It is implemented in Mage_Core_Helper_Abstract */
$smjShipment = Mage::helper('core')->isModuleEnabled('Gitter_Smjshipment');

if ( $smjShipment == false ) {
    // Versand ist abgeschaltet => Eintrag aus "eav_attribute" löschen
    $installer->run("DELETE FROM `eav_attribute` WHERE `attribute_code` LIKE '%smjshipment%' OR `source_model` LIKE '%smjshipment%';");
}

$installer->endSetup();
