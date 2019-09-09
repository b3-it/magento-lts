<?php
/** @var $this Egovs_Base_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();


//machmal wird diese Tabelle aus mage_customer nicht richtig installiert

if (!$installer->tableExists($installer->getTable('customer/flowpassword')))
{
    $table = $installer->getConnection()
        ->newTable($installer->getTable('customer/flowpassword'))
        ->addColumn('flowpassword_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Flow password Id')
        ->addColumn('ip', Varien_Db_Ddl_Table::TYPE_VARCHAR, 50, array(
            'nullable' => false,
        ), 'User IP')
        ->addColumn('email', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
        ), 'Requested email for change')
        ->addColumn('requested_date', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => false,
            'default' => '0000-00-00 00:00:00',
        ), 'Requested date for change')
        ->addIndex($installer->getIdxName('customer/flowpassword', array('email')),
            array('email'))
        ->addIndex($installer->getIdxName('customer/flowpassword', array('ip')),
            array('ip'))
        ->addIndex($installer->getIdxName('customer/flowpassword', array('requested_date')),
            array('requested_date'))
        ->setComment('Customer flow password');
    $installer->getConnection()->createTable($table);
}
$installer->endSetup();
