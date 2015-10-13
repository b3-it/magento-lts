<?php

$installer = $this;

$installer->startSetup();


$installer->run("ALTER TABLE extstock2_stock ADD `delivery_hint` varchar(255) default ''");
$installer->run("ALTER TABLE extstock2_stock ADD `delivery_note` varchar(1024) default ''");



$installer->run("
-- DROP TABLE IF EXISTS extstock2_stock_order;
CREATE TABLE extstock2_stock_order (
  `extstock_stockorder_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_ordered` datetime NULL,
  `date_delivered` datetime NULL,
  `user` varchar(50) NOT NULL default '',
  `instock_id` int(10) unsigned NOT NULL,
  `outstock_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`extstock_stockorder_id`)
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");



$installer->endSetup(); 