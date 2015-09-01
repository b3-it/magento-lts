<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('framecontract_order')};
CREATE TABLE {$this->getTable('framecontract_order')} (
  `framecontract_order_id` int(11) unsigned NOT NULL auto_increment,
  `order_id` int(11) unsigned NOT NULL,
  `framecontract_id` int(11) unsigned NOT NULL,
  `shipping_order_address_id` int(11) unsigned NOT NULL,
  `principal_email` varchar(255) default '',
  `vendor_email` varchar(255) default '',
  `transmit_date` TIMESTAMP default NOW(),
  PRIMARY KEY (`framecontract_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 