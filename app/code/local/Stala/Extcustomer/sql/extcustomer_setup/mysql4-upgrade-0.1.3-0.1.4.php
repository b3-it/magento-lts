<?php
/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('extcustomer_freecopies')};
	CREATE TABLE {$this->getTable('extcustomer_freecopies')} (
		`extcustomer_freecopies_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`customer_id` int(10) UNSIGNED NOT NULL ,
		`product_id` int(10) UNSIGNED NOT NULL ,
		`freecopies` decimal(12,4) UNSIGNED NOT NULL ,
		`base_freecopies` decimal(12,4) UNSIGNED NOT NULL ,
		`option` int(10) UNSIGNED NOT NULL ,
		CONSTRAINT `FK_extcustomer_freecopies_customer_entity_id` FOREIGN KEY (`customer_id`) REFERENCES {$this->getTable('customer_entity')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
		CONSTRAINT `FK_extcustomer_freecopies_catalog_product_entity_id` FOREIGN KEY (`product_id`) REFERENCES {$this->getTable('catalog_product_entity')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
		PRIMARY KEY (`extcustomer_freecopies_id` ) ,
		INDEX ( `product_id` ) ,
		INDEX ( `customer_id` )
	) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");

if (!$installer->getAttribute('customer', 'stala_base_freecopies')) {
	$installer->addAttribute('customer', 'stala_base_freecopies', array(
	    'label' => 'Base Freecopies',
		'input' => 'text',
		'type' => 'int',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => false,
		'required' => false,
		'backend' => 'extcustomer/customer_attribute_backend_freecopies',
		'note' => 'Is set when saving freecopies.',
		'input_renderer' => 'extcustomer/adminhtml_customer_edit_renderer_readonly',
	    'default' => '0',
		)
	);
}

if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
	if (!$installer->getAttribute('quote_item', 'stala_freecopies')) {
		$installer->addAttribute('quote_item', 'stala_freecopies', array('type'=>'decimal'));
	}
	if (!$installer->getAttribute('order_item', 'stala_freecopies')) {
		$installer->addAttribute('order_item', 'stala_freecopies', array('type'=>'decimal'));
	}
} else {
	if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_item'), 'stala_freecopies')) {
		$installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), 'stala_freecopies', 'decimal(12,4)');
	}
	if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), 'stala_freecopies')) {
		$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), 'stala_freecopies', 'decimal(12,4)');
	}
}

$installer->endSetup(); 