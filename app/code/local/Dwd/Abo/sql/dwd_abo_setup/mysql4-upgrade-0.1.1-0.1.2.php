<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('dwd_abo/tierprice_depends')};
CREATE TABLE {$this->getTable('dwd_abo/tierprice_depends')} (
  `tierprice_depends_id` int(11) unsigned NOT NULL auto_increment,
  `provider_orderitem_id` int(11) unsigned default NULL,
  `benefit_orderitem_id` int(11) unsigned default NULL,
   INDEX ( `provider_orderitem_id` ) ,
   INDEX ( `benefit_orderitem_id` ) ,
  PRIMARY KEY (`tierprice_depends_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup();