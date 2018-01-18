<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();

// Deutschland wieder zu EU-Ländern hinzufügen
$this->setConfigData('general/country/eu_countries', 'BE,BG,DE,DK,EE,FI,FR,GR,IE,IT,LV,LT,LU,MT,NL,PL,PT,RO,SE,SK,SI,ES,CZ,HU,GB,CY,AT');


$installer->endSetup();
