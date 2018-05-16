<?php
/**
  *
  * @category   	B3it Messagequeue
  * @package    	b3it_mq
  * @name       	b3it_mq Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();


if (!$installer->tableExists($installer->getTable('b3it_mq/queue_ruleset')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('b3it_mq/queue_ruleset')};
			CREATE TABLE {$installer->getTable('b3it_mq/queue_ruleset')} (
			`id` int(11) unsigned NOT NULL auto_increment,
			`name` varchar(128) default '',
			`status` smallint(6) unsigned default '0',
			`category` varchar(128) default '',
			`recipients` varchar(512) default '',
			`sender_name` varchar(512) default '',
			`sender_email` varchar(512) default '',
			`owner_id` int(11) unsigned default null,
			`renderer` varchar(128) default '',
			`transfer` varchar(128) default 'email',
			`format` varchar(128) default 'plain',
			`subject` varchar(1024) default '',
			`template` text default '',
			`template_html` text default '',
	  		PRIMARY KEY (`id`),
	   		FOREIGN KEY (`owner_id`) REFERENCES `{$this->getTable('admin/user')}`(`user_id`) ON DELETE SET NULL

			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			");
}

if (!$installer->tableExists($installer->getTable('b3it_mq/queue_rule')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('b3it_mq/queue_rule')};
	CREATE TABLE {$installer->getTable('b3it_mq/queue_rule')} (
	  	`id` int(11) unsigned NOT NULL auto_increment,
    	`ruleset_id` int(11) unsigned NOT NULL,
        `join` varchar(12) default 'and',
        `operator` varchar(12) default 'and',
        `compare` varchar(256) default '',
        `compare_value` varchar(256) default '',
        `source` varchar(1024) default '',
     	`is_not` smallint(6) unsigned default '0',
	  PRIMARY KEY (`id`),
    FOREIGN KEY (`ruleset_id`) REFERENCES `{$this->getTable('b3it_mq/queue_ruleset')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('b3it_mq/queue_message')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('b3it_mq/queue_message')};
	CREATE TABLE {$installer->getTable('b3it_mq/queue_message')} (
	  	`id` int(11) unsigned NOT NULL auto_increment,
    	`ruleset_id` int(11) unsigned default NULL,
        `owner_id` int(11) unsigned default NULL,
        `content` text default '',
        `content_html` text default '',
        `recipients` varchar(1024) default '',
        `subject` varchar(1024) default '',
        `created_at` datetime default now(),
        `event` varchar(128) default '',
        `category` varchar(128) default '',
        `processed_at` datetime default now(),
    	`transfer` varchar(128) default 'email',
    	`format` varchar(128) default 'plain',
    	`status` smallint(6) unsigned default '0',
    	`store_id` smallint(6) unsigned default '0',
	  PRIMARY KEY (`id`),
    FOREIGN KEY (`ruleset_id`) REFERENCES `{$this->getTable('b3it_mq/queue_ruleset')}`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`owner_id`) REFERENCES `{$this->getTable('admin/user')}`(`user_id`) ON DELETE SET NULL
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}



if (!$installer->tableExists($installer->getTable('b3it_mq/email_queue'))) {
	$table = $installer->getConnection()
	->newTable($installer->getTable('b3it_mq/email_queue'))
	->addColumn('message_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity' => true,
			'unsigned' => true,
			'nullable' => false,
			'primary' => true,
	), 'Message Id')
	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'unsigned' => true, 'default' => 0
			), 'Status')
	->addColumn('queue_message_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
					'unsigned' => true, 'default' => 0
	), 'Queue Message Id')
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
if (!$installer->tableExists($installer->getTable('b3it_mq/email_recipient'))) {
	$table = $installer->getConnection()
	->newTable($installer->getTable('b3it_mq/email_recipient'))
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
	->addIndex($installer->getIdxName('b3it_mq/email_recipient', array('email')), array('email'))
	->addIndex($installer->getIdxName('b3it_mq/email_recipient', array('message_id', 'email'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE), array('message_id', 'email'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
	->addForeignKey($installer->getFkName('b3it_mq/email_recipient', 'message_id', 'b3it_mq/email_queue', 'message_id'), 'message_id', $installer->getTable('b3it_mq/email_queue'), 'message_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	->setComment('Email Queue');
	$installer->getConnection()->createTable($table);
}

$installer->endSetup();
