<?php
/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$installer->updateAttribute('customer', 'discount_quota_init', 'frontend_label', 'Initial Discount Quota');
$installer->updateAttribute('customer', 'discount_quota_init', 'is_visible', true);
$installer->updateAttribute('customer', 'discount_quota_init', 'backend_model', 'extcustomer/customer_attribute_backend_discount');
if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
	$installer->updateAttribute('customer', 'discount_quota_init', 'frontend_input_renderer', 'extcustomer/adminhtml_customer_edit_renderer_initialdiscount');
} else {
	$installer->updateAttribute('customer', 'discount_quota_init', 'frontend_model', 'extcustomer/customer_attribute_frontend_discount');
}
$installer->updateAttribute('customer', 'discount_quota_init', 'is_required', false);
$installer->updateAttribute('customer', 'discount_quota_init', 'note', 'Is set when saving.');

if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
	$installer->installCustomerForms('discount_quota_init', array('adminhtml_only' => true));
}

$installer->endSetup(); 