<?php

/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getAttribute('customer', 'is_parent_customer')) {
	$installer->addAttribute('customer', 'is_parent_customer', array(
	    'label'   => 'Is Parent Customer',
		'input' => 'select',
		'type' => 'int',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => true,
		'source' => 'eav/entity_attribute_source_boolean',
	    'default' => '0',
		'position' => 100,
		'group' => 'general',
		'required' => false,
		'user_defined' => false,
	));
	
	
	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms('is_parent_customer', array('adminhtml_only' => true));
	}
}



if (!$installer->getAttribute('customer', 'parent_customer_id')) {
	$installer->addAttribute('customer', 'parent_customer_id', array(
		'input' => 'hidden',
		'type' => 'int',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => false,
	    'default' => '0',
		'group' => 'general',
		'required' => false,
		'user_defined' => false,
		
	));
	
	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms('parent_customer_id', array('adminhtml_only' => true));
	}
}


$installer->endSetup();
