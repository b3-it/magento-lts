<?php

/* @var $this Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$settingTableName = $installer->getTable('b3it_modelhistory/history_settings');

if (!$installer->tableExists($settingTableName)) {
    $table = $installer->getConnection()
    ->newTable($settingTableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true
    ), 'ID')
    // the class name of the model
    ->addColumn('model', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ))
    // the class name of the model
    ->addColumn('blocked', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable' => false
    ));
    
    $installer->getConnection()->createTable($table);
}
$installer->endSetup();