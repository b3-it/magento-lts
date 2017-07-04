<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$installer->setConfigData('design/theme/locale', 'gka');
$installer->setConfigData('design/header/welcome', '');
$installer->setConfigData('catalog/price/display_delivery_time_on_categories', 0);

$installer->endSetup();