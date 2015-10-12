<?php

$installer = $this;

$installer->startSetup();

$installer->run("
		DROP TABLE IF EXISTS {$this->getTable('paymentbase/transactions')};
		CREATE TABLE {$this->getTable('paymentbase/transactions')} (
			`bkz` varchar(255) NOT NULL,
			`quote_id` int(10) default NULL,
			`order_id` int(10) default NULL,
			`created_at` datetime NOT NULL default '0000-00-00 00:00:00',
			`updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
			`payment_method` varchar(255) default NULL,
			PRIMARY KEY (`bkz`)
		) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
		");

$installer->endSetup();