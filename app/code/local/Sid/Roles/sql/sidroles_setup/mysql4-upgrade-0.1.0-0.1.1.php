<?php
/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();



if (!$installer->getAttribute('customer', 'checkout_authority')) {
	$installer->addAttribute('customer', 'checkout_authority', array(
	    'label'        => 'Checkout Authority',
		'input' => 'select',
		'type' => 'int',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => true,
		'source' => 'sidroles/customer_attribute_backend_checkout_authority',
	    'default' => '0',
		'position' => 120,
	));
	
	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms('checkout_authority', array('adminhtml_only' => true));
	}
}

if (!$installer->getAttribute('customer', 'dienststelle')) {
	$installer->addAttribute('customer', 'dienststelle', array(
	    'label'  => 'Dienststelle',
		'input' => 'text',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => true,		
	    'default' => '0',
		'position' => 130,
		'required' => false
	));
	
	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms('dienststelle', array('adminhtml_only' => true));
	}
}


$installer->endSetup(); 