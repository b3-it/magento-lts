<?php
/**
 * Resource Collection für Haushaltsparameter.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
$installer = $this;

$installer->startSetup();


if (!$installer->getAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_ADDITIONAL)) {
	$installer->addAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_ADDITIONAL, array(
			'label' => 'SEPA Mandate Additional Data',
			'type' => 'varchar',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'input' => 'text',
				
			'visible' => true,
			//'group' => 'general',
			'required' => false,
			'user_defined' => false,
			'default' => '',
			'sort_order' => 11,
	));


}


$installer->endSetup();