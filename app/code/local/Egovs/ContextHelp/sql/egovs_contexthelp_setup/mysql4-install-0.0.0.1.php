<?php
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$tableName = 'contexthelp';


if (!$installer->tableExists($tableName)) {
	$table = $installer->getConnection()
                       ->newTable($installer->getTable($tableName))
                       ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                           'identity'  => true,
                           'unsigned'  => true,
                           'nullable'  => false,
                           'primary'   => true,
                       ), 'Entity ID')
                       ->addColumn('widgetid', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                           'nullable'  => false,
                           'unsigned'  => true,
                       ), 'Widget Instance ID')
                       ->addColumn('layouthandle', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                       ), 'Layout Handle')
                       ->addColumn('block', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
                       ), 'Internal Block Title')
    ;
    $installer->getConnection()->createTable($table);
}


$installer->endSetup();
