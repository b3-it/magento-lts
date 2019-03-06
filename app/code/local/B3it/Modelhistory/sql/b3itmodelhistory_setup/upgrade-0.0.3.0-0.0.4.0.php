<?php

/* @var $this Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$settingTableName = $installer->getTable('b3it_modelhistory/history_settings');
if ($installer->tableExists($settingTableName)) {
    $installer->getConnection()->dropTable($settingTableName);
}
$installer->endSetup();