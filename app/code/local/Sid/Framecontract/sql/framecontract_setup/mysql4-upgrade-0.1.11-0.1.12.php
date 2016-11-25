<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("ALTER TABLE {$this->getTable('framecontract_los')} Drop `stock_status_send`");

$installer->run("ALTER TABLE {$this->getTable('catalog/product')} ADD `stock_status_send` smallint(6) NOT NULL default 0 ");

$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'stock_status_send', array(
		'type'                    => 'static',
		'input'                   => '',
		'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'                 => false,
		'user_defined'            => false,
		'default'                 => '0',
		'searchable'              => false,
		'filterable'              => false,
		'comparable'              => false,
		'visible_on_front'        => false,

));
$installer->endSetup();