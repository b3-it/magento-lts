<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('egovs_paymentbase_defineparams')};
CREATE TABLE {$this->getTable('egovs_paymentbase_defineparams')} (
  `param_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `ident` varchar(128) NOT NULL default '',
  PRIMARY KEY (`param_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->run("
ALTER TABLE {$this->getTable('egovs_paymentbase_localparams')} DROP COLUMN ident;
");

$installer->run("
ALTER TABLE {$this->getTable('egovs_paymentbase_localparams')} ADD param_id int(11) unsigned NOT NULL;
");

$installer->run("
ALTER TABLE {$this->getTable('egovs_paymentbase_localparams')} ADD FOREIGN KEY (`param_id`) REFERENCES `{$this->getTable('egovs_paymentbase_defineparams')}`(`param_id`) ON DELETE CASCADE;
");

$installer->endSetup();