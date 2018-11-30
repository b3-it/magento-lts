<?php
/**
 * Egovs Infoletter
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Infoletter
 * @name       	Egovs_Infoletter Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();


if (!$installer->tableExists($installer->getTable('infoletter/queue'))) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('infoletter/queue'))
        ->addColumn('message_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Message Id')
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true, 'default' => 0
        ), 'Status')
        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
        ), 'Store')
        ->addColumn('message_body_hash', Varien_Db_Ddl_Table::TYPE_TEXT, 64, array(
            'nullable' => false,
        ), 'Message Body Hash')
        ->addColumn('message_body', Varien_Db_Ddl_Table::TYPE_TEXT, '1024k', array(
            'nullable' => false,
        ), 'Message Body')
        ->addColumn('message_body_plain', Varien_Db_Ddl_Table::TYPE_TEXT, '1024k', array(
            'nullable' => false,
        ), 'Message Body')
        ->addColumn('message_subject', Varien_Db_Ddl_Table::TYPE_TEXT, '512', array(
            'nullable' => false,
        ), 'Message Subject')
        ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, '512', array(
            'nullable' => false,
        ), 'title')
        ->addColumn('sender_name', Varien_Db_Ddl_Table::TYPE_TEXT, '512', array(
            'nullable' => false,
        ), 'Sender name')
        ->addColumn('sender_email', Varien_Db_Ddl_Table::TYPE_TEXT, '512', array(
            'nullable' => false,
        ), 'Senderemail')
        ->addColumn('message_parameters', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
            'nullable' => false,
        ), 'Message Parameters')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Creation Time')
        ->addColumn('processed_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Finish Time')
    ;
    $installer->getConnection()->createTable($table);
}

/**
 * Create table 'core/email_recipients'
*/
if (!$installer->tableExists($installer->getTable('infoletter/recipient'))) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('infoletter/recipient'))
        ->addColumn('recipient_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Recipient Id')
        ->addColumn('message_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
        ), 'Message ID')
        ->addColumn('email', Varien_Db_Ddl_Table::TYPE_TEXT, 128, array(
            'nullable' => false,
        ), 'Recipient Email')
        ->addColumn('prefix', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array('nullable' => false, 'default' => ''), 'Recipient Name')
        ->addColumn('firstname', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array('nullable' => false, 'default' => ''), 'Recipient Name')
        ->addColumn('lastname', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array('nullable' => false, 'default' => ''), 'Recipient Name')
        ->addColumn('company', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array('nullable' => false, 'default' => ''), 'Recipient Name')
        ->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true, 'default' => 0
        ), 'Status')
        ->addColumn('processed_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(), 'Finish Time')
        ->addColumn('error_text', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
            'nullable' => true,
        ), 'Error')
        ->addIndex($installer->getIdxName('infoletter/recipient', array('email')), array('email'))
        ->addIndex($installer->getIdxName('infoletter/recipient', array('message_id', 'email'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE), array('message_id', 'email'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
        ->addForeignKey($installer->getFkName('infoletter/recipient', 'message_id', 'infoletter/queue', 'message_id'), 'message_id', $installer->getTable('infoletter/queue'), 'message_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->setComment('Email Queue');
    $installer->getConnection()->createTable($table);
}

$installer->endSetup(); 