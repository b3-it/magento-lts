<?php

$installer = $this;

$installer->startSetup();


$entityTypeId = 'order_payment';
$attributeId = 'saferpay_transaction_id';

if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
	$installer->addAttribute($entityTypeId, $attributeId, array(
	    'label' => 'Saferpay Transaction ID',
	    'input' => 'text',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => true,
	    'required' => false,
	    'user_defined' => false,
	    'searchable' => false,
	    'comparable' => false,
	    'visible_on_front' => false,
	    'visible_in_advanced_search' => false,
	    'default' => '0',
	));
} else {
	//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
	$installer->getConnection()->addColumn(
		$installer->getTable('sales/order_payment'),
	    'saferpay_transaction_id',
		'varchar(255)'
	);
}


$installer->endSetup(); 