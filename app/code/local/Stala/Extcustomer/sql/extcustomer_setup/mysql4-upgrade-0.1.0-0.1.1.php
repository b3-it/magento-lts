<?php
/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('extcustomer_sales_discount')};
	CREATE TABLE {$this->getTable('extcustomer_sales_discount')} (
		`extcustomer_sales_discount_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		`sales_quote_item_id` int(10) UNSIGNED NOT NULL ,
		`customer_id` int(10) UNSIGNED NOT NULL ,
		`discount` decimal(10,2) UNSIGNED NOT NULL ,
		CONSTRAINT `FK_extcustomer_sales_quote_item_id` FOREIGN KEY (`sales_quote_item_id`) REFERENCES {$this->getTable('sales_flat_quote_item')} (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
		CONSTRAINT `FK_extcustomer_customer_entity_id` FOREIGN KEY (`customer_id`) REFERENCES {$this->getTable('customer_entity')} (`entity_id`) ON DELETE CASCADE ON UPDATE CASCADE,
		PRIMARY KEY (`extcustomer_sales_discount_id` ) ,
		INDEX ( `sales_quote_item_id` ) ,
		INDEX ( `customer_id` )
	) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
");

if (!$installer->getAttribute('customer', 'discount_quota')) {
	$installer->addAttribute('customer', 'discount_quota', array(
	    'label'        => 'Discount Quota',
		'input' => 'text',
		'type' => 'decimal',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => true,
		'backend' => 'extcustomer/customer_attribute_backend_discount',
	    'default' => '0',
		'position' => 110,
	));
	
	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms('discount_quota', array('adminhtml_only' => true));
	}
}



if (!$installer->getAttribute('customer', 'discount_quota_init')) {
	$installer->addAttribute('customer', 'discount_quota_init', array(
		'type' => 'decimal',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => false,
	    'default' => '0',
		'position' => 111,
	));
}

$installer->endSetup(); 