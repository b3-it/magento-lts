<?php

$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('extnewsletter_subscriber')};
CREATE TABLE {$this->getTable('extnewsletter_subscriber')} (
  `extnewsletter_id` int(11) unsigned NOT NULL auto_increment,
  `subscriber_id` int(11) unsigned NOT NULL,
  `product_id` int(11) unsigned NOT NULL,
  `is_active` smallint(6) NOT NULL default '0',
  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog_product_entity')}`(`entity_id`) ON DELETE CASCADE,
  FOREIGN KEY (`subscriber_id`) REFERENCES `{$this->getTable('newsletter_subscriber')}`(`subscriber_id`) ON DELETE CASCADE,
  PRIMARY KEY (`extnewsletter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('extnewsletter_queue_product')};
CREATE TABLE {$this->getTable('extnewsletter_queue_product')} (
  `extnewsletter_queue_product_id` int(11) unsigned NOT NULL auto_increment,
  `product_id` int(11) unsigned NOT NULL,
  `queue_id` int(11) unsigned NOT NULL,
   FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog_product_entity')}`(`entity_id`) ON DELETE CASCADE,
   FOREIGN KEY (`queue_id`) REFERENCES `{$this->getTable('newsletter_queue')}`(`queue_id`) ON DELETE CASCADE,
  PRIMARY KEY (`extnewsletter_queue_product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");



$installer->addAttribute('catalog_product', 'extnewsletter', array(
    'label' => 'Product Newsletter',
    'input' => 'boolean',
	'type' => 'int',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '0',
	'group'   => 'General',
));




$installer->endSetup(); 