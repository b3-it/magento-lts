<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('pdftemplate_blocks')};
CREATE TABLE {$this->getTable('pdftemplate_blocks')} (
  `pdftemplate_blocks_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `ident` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `payment` varchar(255) NOT NULL default '',
  `customer_group` int  NULL default -1,
  `shipping` varchar(255) NOT NULL default '',
  `store_id` smallint(6) NOT NULL default '0',
  `prio` smallint(6) NOT NULL default '0',
  `pos` smallint(6) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`pdftemplate_blocks_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 