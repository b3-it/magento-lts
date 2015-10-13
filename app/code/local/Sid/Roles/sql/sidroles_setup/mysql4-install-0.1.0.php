<?php

$installer = $this;

$installer->startSetup();


$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('sid_roles_customergroups')};
CREATE TABLE {$this->getTable('sid_roles_customergroups')} (
  `sid_roles_customergroups_id` int(11) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `customer_group_id` smallint(5) unsigned NOT NULL,
  `read` smallint(6) NOT NULL default '0',
  `write` smallint(6) NOT NULL default '0',
  FOREIGN KEY (`user_id`) REFERENCES {$this->getTable('admin_user')} (user_id) ON DELETE CASCADE,
  FOREIGN KEY (`customer_group_id`) REFERENCES {$this->getTable('customer_group')} (customer_group_id) ON DELETE CASCADE,
  PRIMARY KEY (`sid_roles_customergroups_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");


$installer->run("ALTER TABLE {$this->getTable('admin_user')} ADD (`allow_all_customergroups` smallint(5) NOT NULL default 0) ");

$installer->endSetup(); 