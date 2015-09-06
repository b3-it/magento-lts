<?php

$installer = $this;

$installer->startSetup();


$installer->run("
-- DROP TABLE IF EXISTS extstock2_stock;
CREATE TABLE extstock2_stock (
`stock_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL default '',
`addressname` varchar(255) NOT NULL default '',
`street` varchar(255) NOT NULL default '',
`city` varchar(255) NOT NULL default '',
`postcode` varchar(255) NOT NULL default '',
`phone` varchar(255) NOT NULL default '',
`fax` varchar(255) NOT NULL default '',
`email` varchar(255) NOT NULL default '',
`type` smallint(6) UNSIGNED NOT NULL ,
`default_warning_qty` decimal(12,2) NOT NULL default '0',
`default_order_qty` decimal(12,2) NOT NULL default '0',
PRIMARY KEY (`stock_id` ) 
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");



$installer->run("
-- DROP TABLE IF EXISTS extstock2;
CREATE TABLE extstock2 (
  `extstock_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `distributor` varchar(255) NOT NULL default '',
  `quantity` INT NOT NULL default '0' COMMENT 'Aktueller Bestand',
  `quantity_ordered` INT NOT NULL  default '0' COMMENT 'Bestellte Menge',
  `price` decimal(12,2) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `date_ordered` datetime NULL,
  `date_delivered` datetime NULL,
  `storage` varchar(50) NOT NULL default '',
  `rack` varchar(50) NOT NULL default '',
  `stock_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`extstock_id`),
  FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity`(`entity_id`) ON DELETE CASCADE,
  FOREIGN KEY (`stock_id`) REFERENCES `extstock2_stock`(`stock_id`) ON DELETE CASCADE,
  INDEX ( `product_id` ) ,
  INDEX ( `status` ),
  INDEX ( `stock_id` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");



$installer->run("
-- DROP TABLE IF EXISTS extstock2_sales_order;
CREATE TABLE extstock2_sales_order (
`extstock_sales_order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`extstock_id` int(10) UNSIGNED NOT NULL ,
`sales_order_id` int(10) UNSIGNED NOT NULL ,
`qty_ordered` int(10) UNSIGNED NOT NULL ,
`stock_id` int(10) unsigned NOT NULL,
FOREIGN KEY (`sales_order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE,
FOREIGN KEY (`extstock_id`) REFERENCES `extstock2`(`extstock_id`) ON DELETE CASCADE,
FOREIGN KEY (`stock_id`) REFERENCES `extstock2_stock`(`stock_id`) ON DELETE CASCADE,
PRIMARY KEY (`extstock_sales_order_id` ) ,
INDEX ( `sales_order_id` ) ,
INDEX ( `extstock_id` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");


$installer->run("
-- DROP TABLE IF EXISTS extstock2_stock_journal;
CREATE TABLE extstock2_stock_journal (
  `journal_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `qty` INT NOT NULL  default '0' ,
  `status` smallint(6) NOT NULL default '0',
  `date_ordered` datetime NULL,
  `date_delivered` datetime NULL,
  `input_stock_id` int(10) unsigned NOT NULL,
  `output_stock_id` int(10) unsigned NOT NULL,
  `note` varchar(500) default '',
  `user_ident` varchar(50) default '',
  PRIMARY KEY (`journal_id`),
  FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity`(`entity_id`) ON DELETE CASCADE,
  FOREIGN KEY (`input_stock_id`) REFERENCES `extstock2_stock`(`stock_id`) ON DELETE CASCADE,
  FOREIGN KEY (`output_stock_id`) REFERENCES `extstock2_stock`(`stock_id`) ON DELETE CASCADE,
  INDEX ( `product_id` ) ,
  INDEX ( `status` ),
  INDEX ( `input_stock_id` ),
  INDEX ( `output_stock_id` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");



$installer->endSetup(); 