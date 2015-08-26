<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('ibewi_access')};
CREATE TABLE {$this->getTable('ibewi_access')} (
  `ibewi_access_id` int(11) unsigned NOT NULL auto_increment,
  `user` varchar(255) NOT NULL default '',
  `request_begin` datetime NULL ,
  `request_end` datetime NULL ,
  `type` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  PRIMARY KEY (`ibewi_access_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 