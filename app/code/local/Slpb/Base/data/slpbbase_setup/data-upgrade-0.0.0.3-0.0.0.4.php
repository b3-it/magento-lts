<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

// Anpassungen für Migration https://trac.kawatest.de/ticket/2870

$installer->setConfigData('sendfriend/email/enabled', 0);
$installer->setConfigData('catalog/price/display_zero_tax_below_price', 0);
$installer->setConfigData('tax/display/type', 1);
$installer->setConfigData('tax_cart_display_price', 1);
$installer->setConfigData('tax/cart_display/subtotal', 1);
$installer->setConfigData('tax/cart_display/shipping', 1);
$installer->setConfigData('tax/cart_display/grandtotal', 0);
$installer->setConfigData('tax/cart_display/full_summary', 0);
$installer->setConfigData('tax/cart_display/zero_tax', 0);
$installer->setConfigData('tax/sales_display/price', 1);
$installer->setConfigData('tax/sales_display/subtotal', 1);
$installer->setConfigData('tax/sales_display/shipping', 1);
$installer->setConfigData('tax/sales_display/grandtotal', 0);
$installer->setConfigData('tax/sales_display/full_summary', 0);
$installer->setConfigData('tax/sales_display/zero_tax', 0);
$installer->setConfigData('shipping/estimate_costs/show_at_card', 0);
$installer->setConfigData('customer/registerrequired/company', null);
$installer->setConfigData('customer/registerrequired/taxvat', null);
$installer->setConfigData('customer/shippingrequired/company', null);

$page = Mage::getModel('cms/page')->load('abholungspauschale', 'identifier');
if ( !$page->isEmpty()) {
	$page->addData(array('root_template' => 'one_column', 'stores' => array(0)))->save();
}
		
$installer->endSetup();
