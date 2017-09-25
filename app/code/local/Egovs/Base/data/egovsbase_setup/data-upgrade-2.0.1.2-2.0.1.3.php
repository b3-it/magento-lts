<?php

/* @var $installer Mage_Core_Model_Resource_Setup */
/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$_checkKeys = array(
    'payment/sepadebitsax/mandate_amendment_template',
    'payment/sepadebitsax/mandate_template',
    'payment/sepadebitsax/notification_template'
);

foreach($_checkKeys AS $configKey) {
    $values = Mage::getConfig()->getStoresConfigByPath($configKey);

    if ( count($values) ) {
        foreach($values AS $store => $value) {
            $value = intval($value);
            if ( !is_int($value) OR ($value <= 0) ) {
                $this->deleteConfigData($configKey, $store);
            }
        }
    }
}

$installer->endSetup();