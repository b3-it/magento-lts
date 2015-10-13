<?php

$installer = $this;

$installer->startSetup();

$installer->run("

 DROP TABLE IF EXISTS {$this->getTable('verteiler_verteiler')};
CREATE TABLE {$this->getTable('verteiler_verteiler')} (
  `verteiler_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`verteiler_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

   

 DROP TABLE IF EXISTS {$this->getTable('verteiler_customer')};
CREATE TABLE {$this->getTable('verteiler_customer')} (
  `verteiler_customer_id` int(11) unsigned NOT NULL auto_increment,
  `verteiler_id` int(11) unsigned NOT NULL,
  `customer_id` int(11) unsigned NOT NULL,
  FOREIGN KEY (`verteiler_id`) REFERENCES `verteiler_verteiler`(`verteiler_id`) ON DELETE CASCADE,
  FOREIGN KEY (`customer_id`) REFERENCES `customer_entity`(`entity_id`) ON DELETE CASCADE,
  PRIMARY KEY (`verteiler_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 