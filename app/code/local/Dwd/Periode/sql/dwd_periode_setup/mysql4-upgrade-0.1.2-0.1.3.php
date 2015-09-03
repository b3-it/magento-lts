<?php

$installer = $this;

$installer->startSetup();




$installer->run("
		DROP TABLE IF EXISTS {$this->getTable('periode/tier_price')};
		CREATE TABLE {$this->getTable('periode/tier_price')}(
  `periode_tierprice_id` int(11) unsigned NOT NULL auto_increment,
  `periode_id` int(11) unsigned NOT NULL,
  `qty` int(11) default 0,
  `price`decimal(10,2) default 0,
  FOREIGN KEY (`periode_id`) REFERENCES `{$this->getTable('periode/periode')}`(`entity_id`) ON DELETE CASCADE,
  PRIMARY KEY (`periode_tierprice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");




$installer->endSetup(); 
