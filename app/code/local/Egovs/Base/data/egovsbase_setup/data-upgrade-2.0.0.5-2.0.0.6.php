<?php
/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$entityType = 'customer_address';
$attributeCode = 'taxvat';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if ($att && !$att->isEmpty()) {
	$att->setData('used_in_forms', array())->save();
}


$installer->endSetup();
