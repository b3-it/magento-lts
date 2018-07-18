<?php

/** @var \Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

$table = $installer->getTable('exportorder/transfer_post');
if ($installer->tableExists($table)
    && !$installer->getConnection()->tableColumnExists($table, 'client_certificate')) {
    $installer->getConnection()->addColumn($table, 'clientcert_auth', array(
        'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
        'unsigned' => true,
        'default'  => '0',
        'comment'  => 'Use authentication with client certificates',
    ));
    $installer->getConnection()->addColumn($table, 'client_certificate', 'varchar(255)');
    $installer->getConnection()->addColumn($table, 'client_ca', 'varchar(255)');
}
$installer->endSetup();