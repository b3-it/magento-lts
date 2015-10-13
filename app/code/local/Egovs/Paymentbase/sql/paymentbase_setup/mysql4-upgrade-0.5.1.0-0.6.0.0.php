<?php
/**
 * Resource Collection für Haushaltsparameter.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
$installer = $this;

$installer->startSetup();

if (!$installer->getAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID)) {
	$installer->addAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, array(
			'label' => 'SEPA Mandate ID',
			'type' => 'varchar',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'input' => 'text',
			'frontend' => 'paymentbase/customer_attribute_frontend_mandate',
			'visible' => true,
			'group' => 'general',
			'required' => false,
			'user_defined' => false,
			'default' => '',
			'sort_order' => 11,
	));

	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, array('adminhtml_only' => true));
	}
}

$installer->endSetup();