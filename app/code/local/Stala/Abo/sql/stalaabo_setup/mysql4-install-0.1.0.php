<?php

$installer = $this;

$installer->startSetup();



$installer->run("

DROP TABLE IF EXISTS {$this->getTable('stala_abo_contract')};
CREATE TABLE {$this->getTable('stala_abo_contract')} (
  `abo_contract_id` int(11) unsigned NOT NULL auto_increment,
  `base_product_id` int(11) unsigned NOT NULL,
  `qty` int(10) default 0,
  `customer_id` int(11) unsigned NOT NULL,
  `shipping_address_id` int(11) unsigned ,
  `billing_address_id` int(11) unsigned ,	
  `status` smallint(6) NOT NULL default '0',
  `created_time` timestamp default NOW(),
  `from_date` datetime NULL,
  PRIMARY KEY (`abo_contract_id`),
  FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer/entity')}`(`entity_id`) ON DELETE RESTRICT,
  FOREIGN KEY (`base_product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");


$installer->run("

DROP TABLE IF EXISTS {$this->getTable('stala_abo_delivered')};
CREATE TABLE {$this->getTable('stala_abo_delivered')} (
  `abo_deliver_id` int(11) unsigned NOT NULL auto_increment,
  `product_id` int(11) unsigned NOT NULL,
  `contract_qty` int(10) default 0,
  `shipping_qty` int(10) default 0,
  `invoiced_qty` int(10) default 0,
  `abo_contract_id` int(11) unsigned NOT NULL,
  `created_time` timestamp default NOW(),
  `shipping_date` datetime NULL,
  `invoice_date` datetime NULL,
  PRIMARY KEY (`abo_deliver_id`),
  FOREIGN KEY (`abo_contract_id`) REFERENCES `{$this->getTable('stala_abo_contract')}`(`abo_contract_id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->addAttribute('catalog_product', 'is_abo_base_product', array(
    'label'        => 'Is Abo Base Product',
	'input' => 'select',
	'type' => 'int',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
	'source' => 'eav/entity_attribute_source_boolean',
    'default' => '0',
));

$installer->addAttribute('catalog_product', 'abo_parent_product', array(
    'label' => 'Abo Parent Product',
	'input' => 'hidden',
	'type' => 'int',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => false,
	'required' => false,
	'user_defined' => false,
    'default' => '0',
));


$installer->addAttribute('catalog_product', 'abo_product_release_date', array(
    'label' => 'Abo Product Release Date',
	'input' => 'date',
	'type' => 'datetime',
	'backend' => 'eav/entity_attribute_backend_datetime',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
	'required' => false,
    //'default' => '0',
));


$installer->endSetup(); 