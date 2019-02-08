<?php
/** @var $this Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

// Warenkorb-Sidebar :: Zwischensumme im Warenkorb anzeigen
$this->setConfigData('checkout/sidebar/show_subtotal', '1');

$installer->endSetup();