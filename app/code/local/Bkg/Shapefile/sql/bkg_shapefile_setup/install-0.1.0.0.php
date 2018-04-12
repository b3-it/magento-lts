<?php


/** @var $this Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$shapefile = 'bkg_shapefile/file';
$shape = 'bkg_shapefile/shape';

if (!$installer->tableExists($installer->getTable($shapefile))) {
    $table = $installer->getConnection()
    ->newTable($installer->getTable($shapefile))
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity' => true,
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'auto_increment' => true
    ), 'Id')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => '0',
    ), 'Customer Id')
    ->addColumn('georef_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned' => true,
        'nullable' => false,
        'default' => '0',
    ), 'Georef Id')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'Name')
    ->addColumn('zIndex', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable' => false,
        'default' => '0',
    ), 'ZIndex')
    ->addForeignKey(
        $installer->getFkName($shapefile, 'customer_id', "customer/entity", 'entity_id'),
        'customer_id', $installer->getTable("customer/entity"), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName($shapefile, 'georef_id', "virtualgeo/components_georef_entity", 'id'),
        'georef_id', $installer->getTable("virtualgeo/components_georef_entity"), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment($installer->getTable($shapefile));
    $installer->getConnection()->createTable($table);
}
if (!$installer->tableExists($installer->getTable($shape))) {
    // need to use geometry there, because it can be different types

    $installer->run("CREATE TABLE {$installer->getTable($shape)} (
    `id` int(11) unsigned NOT NULL auto_increment,
	`file_id` int(11) unsigned NOT NULL,
    `shape` geometry NOT NULL,
    
    PRIMARY KEY (`id`),
    FOREIGN KEY (`file_id`) REFERENCES `{$installer->getTable($shapefile)}`(`id`) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
}

$installer->endSetup();