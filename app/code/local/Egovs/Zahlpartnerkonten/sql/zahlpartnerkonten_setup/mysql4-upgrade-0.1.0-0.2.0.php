<?php

$installer = $this;

$installer->startSetup();

/* @var $installer Mage_Eav_Model_Entity_Setup */
$entityTypeId = 'order_payment';
$attributeId = 'betrag_hauptforderungen';


if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
	if (!$installer->getAttribute($entityTypeId, $attributeId)) {
		$installer->addAttribute($entityTypeId, $attributeId, array(
				'input' => 'hidden',
				'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
				'visible' => false,
				'required' => false,
				'user_defined' => false,
				'searchable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'visible_in_advanced_search' => false,
				'default' => '0',
		));
	}
} else {
	//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
	if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {
		$installer->getConnection()->addColumn(
				$installer->getTable('sales/order_payment'),
				$attributeId,
				'decimal(12,4)'
		);
	}
}

$installer->endSetup(); 