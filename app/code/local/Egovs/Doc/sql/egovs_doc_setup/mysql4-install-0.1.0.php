<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('egovs_doc')};
CREATE TABLE {$this->getTable('egovs_doc')} (
  `doc_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `description` varchar(1024) NOT NULL default '',
  `category` varchar(255) NOT NULL default '',
  `filename` varchar(512) NOT NULL default '',
  `owner` varchar(128) NOT NULL default '',
  `editor` varchar(128) NOT NULL default '',
  `savefilename` varchar(512) NOT NULL default '',
  `content` text NOT NULL default '',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`doc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 