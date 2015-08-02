<?php

$installer = $this;

$installer->startSetup();
$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('informationservice_requesttype')};
	CREATE TABLE {$this->getTable('informationservice_requesttype')} (
	  `requesttype_id` int(11) unsigned NOT NULL auto_increment,
	  `title` varchar(255) NOT NULL default '',
	  `direction` smallint(6) NOT NULL default '0',
	  PRIMARY KEY (`requesttype_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("INSERT INTO {$this->getTable('informationservice_requesttype')} (title,direction) VALUES ('Anfrage per Telefon',1);");
$installer->run("INSERT INTO {$this->getTable('informationservice_requesttype')} (title,direction) VALUES ('Anfrage per E-Mail',1);");
$installer->run("INSERT INTO {$this->getTable('informationservice_requesttype')} (title,direction) VALUES ('Kopie per Post',0);");
$installer->run("INSERT INTO {$this->getTable('informationservice_requesttype')} (title,direction) VALUES ('Kopie per E-Mail',0);");



$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('informationservice_request')};
	CREATE TABLE {$this->getTable('informationservice_request')} (
	  `request_id` int(11) unsigned NOT NULL auto_increment,
	  `customer_id` int(11) unsigned NOT NULL,
	  `address_id` int(11) unsigned NOT NULL,
	  `title` varchar(255) default '',
	  `replay_email` varchar(128) default '',
	  `content` varchar(4096)  default '',
	  `status` smallint(6) NOT NULL default '0',
	  `created_time` timestamp default NOW(),
	  `deadline_time` datetime,
	  `input_type` int(11) unsigned NOT NULL default '0',
	  `output_type` int(11) unsigned NOT NULL default '0',
	  `category_id` int(10) unsigned NOT NULL default '0',
	  `owner_id` int(10) unsigned NOT NULL ,
	  `reporter_id` mediumint(9) unsigned NOT NULL,
	  `cost` decimal default 0,
	  `result_sku` varchar(125),
	  `order_increment_id` int(11) unsigned default 0,
	  PRIMARY KEY (`request_id`),
	  FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer/entity')}`(`entity_id`) ON DELETE RESTRICT,
	  FOREIGN KEY (`address_id`) REFERENCES `{$this->getTable('customer/address_entity')}`(`entity_id`) ON DELETE RESTRICT,
	  FOREIGN KEY (`category_id`) REFERENCES `{$this->getTable('catalog/category')}`(`entity_id`) ON DELETE RESTRICT,
	  FOREIGN KEY (`owner_id`) REFERENCES `{$this->getTable('admin/user')}`(`user_id`) ON DELETE RESTRICT,
	  FOREIGN KEY (`input_type`) REFERENCES `{$this->getTable('informationservice_requesttype')}`(`requesttype_id`) ON DELETE RESTRICT,
	  FOREIGN KEY (`output_type`) REFERENCES `{$this->getTable('informationservice_requesttype')}`(`requesttype_id`) ON DELETE RESTRICT
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 ");

$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('informationservice_task')};
	CREATE TABLE {$this->getTable('informationservice_task')} (
	  `task_id` int(11) unsigned NOT NULL auto_increment,
	  `request_id` int(11) unsigned NOT NULL,
	  `title` varchar(255) NOT NULL default '',
	  `content` varchar(4096)  default '',
	  `newstatus` smallint(6) NOT NULL default '0',
	  `created_time` timestamp default NOW(),
	  `owner_id` int(10) unsigned NOT NULL,
	  `user_id` int(10) unsigned NOT NULL,
	  `email_send` int(4) unsigned NOT NULL default 0,
	  `cost` decimal default 0,
	  PRIMARY KEY (`task_id`),
	  FOREIGN KEY (`request_id`) REFERENCES `{$this->getTable('informationservice_request')}`(`request_id`) ON DELETE CASCADE,
	  FOREIGN KEY (`owner_id`) REFERENCES `{$this->getTable('admin/user')}`(`user_id`) ON DELETE RESTRICT,
	  FOREIGN KEY (`user_id`) REFERENCES `{$this->getTable('admin/user')}`(`user_id`) ON DELETE RESTRICT  
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup(); 