<?php

/** @var \Mage_Core_Model_Resource_Setup $installer */
$installer = $this;

$installer->startSetup();

$table = $installer->getTable('exportorder/transfer_post');
if ($installer->tableExists($table)
    && !$installer->getConnection()->tableColumnExists($table, 'client_certificate_pwd')) {
    $installer->getConnection()->addColumn($table, 'client_certificate_pwd', 'varchar(255)');
}
$installer->endSetup();