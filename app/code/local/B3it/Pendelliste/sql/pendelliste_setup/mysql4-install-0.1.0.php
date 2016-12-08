<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('b3it_pendelliste')};
CREATE TABLE {$this->getTable('b3it_pendelliste')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `store_id` int(5) unsigned default 0,
  `task_id` int(11) unsigned NOT NULL,
  `model` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `manuell` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 