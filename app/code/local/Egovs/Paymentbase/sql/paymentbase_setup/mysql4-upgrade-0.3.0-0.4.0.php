<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('egovs_paymentbase_localparams')};
CREATE TABLE {$this->getTable('egovs_paymentbase_localparams')} (
  `paymentbase_localparams_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `ident` varchar(128) NOT NULL default '',
  `value` varchar(128) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `priority` smallint(6) NOT NULL default '0',
  `lower` decimal(10,2) default 0,
  `upper` decimal(10,2) default 99999999.99,
  `customer_group_id` smallint(5) unsigned NULL default NULL,
  `payment_method` varchar(128) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`paymentbase_localparams_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");



$installer->endSetup();