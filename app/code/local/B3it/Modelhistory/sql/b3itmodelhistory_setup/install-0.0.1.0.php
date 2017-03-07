<?php
/* @var $this Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$modelTableName = $installer->getTable('b3it_modelhistory/history_entries');
$configTableName = $installer->getTable('b3it_modelhistory/history_config');

if (!$installer->tableExists($modelTableName)) {
    $table = $installer->getConnection()
        ->newTable($modelTableName)
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
    ->addColumn('model_id', Varien_Db_Ddl_Table::TYPE_INTEGER, array())

    // big text data to store
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    ->addColumn('old_value', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())

    // 1 created, 2 updated, 3 deleted
    ->addColumn('type', Varien_Db_Ddl_Table::TYPE_INTEGER, array())

    // enough size store IPv6
    ->addColumn('ip', Varien_Db_Ddl_Table::TYPE_TEXT, 39, array(
        'nullable' => false
    ))

    // enough size store most user names
    ->addColumn('user', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ))

    // size enough for the hash to be stored
    ->addColumn('secret', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        'nullable' => false
    ))

    // the date when the model was changed
    ->addColumn('date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ))
    
    // the revision, does increate when changing existing object
    ->addColumn('rev', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true
    ), 'Revision');
    
    // ->setComment('Magentotutorial weblog/blogpost entity table')
    
    // $table->addIndex('model_index', array('model', 'model_id'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE));
    
    $installer->getConnection()->createTable($table);
}

if (!$installer->tableExists($configTableName)) {
    $table = $installer->getConnection()
    ->newTable($configTableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true
    ), 'ID')

    
    ->addColumn('path', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ))
    ->addColumn('group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, array())
    ->addColumn('store_code', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    ->addColumn('website_code', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    ->addColumn('scope', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    ->addColumn('model_id', Varien_Db_Ddl_Table::TYPE_INTEGER, array())
    
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    ->addColumn('old_value', Varien_Db_Ddl_Table::TYPE_TEXT, null, array())
    
    // 1 created, 2 updated, 3 deleted
    ->addColumn('type', Varien_Db_Ddl_Table::TYPE_INTEGER, array())
    
    // enough size store IPv6
    ->addColumn('ip', Varien_Db_Ddl_Table::TYPE_TEXT, 39, array(
        'nullable' => false
    ))
    
    // enough size store most user names
    ->addColumn('user', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ))
    
    // size enough for the hash to be stored
    ->addColumn('secret', Varien_Db_Ddl_Table::TYPE_TEXT, 32, array(
        'nullable' => false
    ))
    
    // the date when the model was changed
    ->addColumn('date', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'default' => Varien_Db_Ddl_Table::TIMESTAMP_INIT
    ))
    // the revision, does increate when changing existing object
    ->addColumn('rev', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true
    ), 'Revision');

    $installer->getConnection()->createTable($table);
}

$installer->endSetup();