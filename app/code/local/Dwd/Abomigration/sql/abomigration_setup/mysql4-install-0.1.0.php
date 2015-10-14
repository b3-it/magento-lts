<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('dwd_abomigration')};
CREATE TABLE {$this->getTable('dwd_abomigration')} (
  `abomigration_id` int(11) unsigned NOT NULL auto_increment,
  `customer_id` int(11) unsigned default 0,
  `website_id` int(11) unsigned default 0,
  `store_id` int(11) unsigned default 0,
  `address_id` int(11) unsigned default 0,
  `create_customer` smallint(6) NOT NULL default '0',
  `prefix` varchar(128) NOT NULL default '',
  `firstname` varchar(512) NOT NULL default '',
  `lastname` varchar(512) NOT NULL default '',
  `company1` varchar(512) NOT NULL default '',
  `company2` varchar(512) NOT NULL default '',
  `street` varchar(512) NOT NULL default '',
  `city` varchar(512) NOT NULL default '',
  `postcode` varchar(128) NOT NULL default '',
  `telephone` varchar(128) NOT NULL default '',
  `country` varchar(128) NOT NULL default 'DE',
  `email` varchar(512) NOT NULL default '',
  `pwd` varchar(512) NOT NULL default '',
  `pwd_shop` varchar(512) NOT NULL default '',
  `pwd_ldap` varchar(512) NOT NULL default '',
  `username_ldap` varchar(512) NOT NULL default '',
  `sku` varchar(512) NOT NULL default '',
  `pwd_shop_is_safe` smallint(6) NOT NULL default '0',
  `pwd_ldap_is_safe` smallint(6) NOT NULL default '0',
  `product_id` int(11) unsigned default 0,
  `period_id` int(11) unsigned default 0,
  `order_id` int(11) unsigned default 0,
  `station1` varchar(128) NOT NULL default '',
  `station2` varchar(128) NOT NULL default '',
  `station3` varchar(128) NOT NULL default '',
  `station4` varchar(128) NOT NULL default '',
  `period_end` datetime NOT NULL,
  `customer_informed` datetime NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  `error` smallint(6) NOT NULL default '0',
  `error_text` varchar(512) NOT NULL default '',
  PRIMARY KEY (`abomigration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 

