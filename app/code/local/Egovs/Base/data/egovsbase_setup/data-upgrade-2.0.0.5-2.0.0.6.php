<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();

$entityType = 'customer_address';
$attributeCode = 'taxvat';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if ($att && !$att->isEmpty()) {
	$att->setData('used_in_forms', array())->save();
}


$installer->endSetup();
