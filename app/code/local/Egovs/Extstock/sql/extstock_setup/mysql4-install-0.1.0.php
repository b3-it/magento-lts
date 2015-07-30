<?php

$installer = $this;

$installer->startSetup();

$installer->run("
DROP TABLE IF EXISTS {$this->getTable('extstock')};
CREATE TABLE {$this->getTable('extstock')} (
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
  PRIMARY KEY (`extstock_id`),
  FOREIGN KEY (`product_id`) REFERENCES `catalog_product_entity`(`entity_id`) ON DELETE CASCADE,
  INDEX ( `product_id` ) ,
  INDEX ( `status` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;

    ");


/*
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('extstock_sales_order')};
CREATE TABLE {$this->getTable('extstock_sales_order')} (
`extstock_sales_order_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
`extstock_id` int(10) UNSIGNED NOT NULL ,
`sales_order_id` int(10) UNSIGNED NOT NULL ,
`qty_ordered` int(10) UNSIGNED NOT NULL ,
FOREIGN KEY (`sales_order_id`) REFERENCES `sales_order`(`entity_id`) ON DELETE CASCADE,
FOREIGN KEY (`extstock_id`) REFERENCES `extstock`(`extstock_id`) ON DELETE CASCADE,
PRIMARY KEY (`extstock_sales_order_id` ) ,
INDEX ( `sales_order_id` ) ,
INDEX ( `extstock_id` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");

*/


$installer->endSetup(); 