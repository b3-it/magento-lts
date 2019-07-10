<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$entityType = 'customer_address';
$forms=array('adminhtml_customer_address','customer_address_edit', 'customer_register_address','customer_account_create');
$attributeCode = 'academic_titel';

$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '0')->save();



$installer->endSetup();