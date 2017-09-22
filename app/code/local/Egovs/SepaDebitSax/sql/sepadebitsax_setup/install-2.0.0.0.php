<?php
/**
 *
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package         Egovs_Ready
 * @name            Egovs_Ready_Helper_Data
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/** @var $this Egovs_Paymentbase_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$entityTypeId = 'order_payment';

$attributes = array(
		Egovs_SepaDebitSax_Helper_Data::ATTRIBUTE_ESHOP_TRANSACTION_ID,
		Egovs_SepaDebitSax_Helper_Data::ATTRIBUTE_SEPA_MATURITY,

);

foreach ($attributes as $attributeId) {
	if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
		if (!$installer->getAttribute($entityTypeId, $attributeId)) {
			$installer->addAttribute($entityTypeId, $attributeId, array(
					'label' => 'EShop Transaction ID',
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
			)
			);
		}
	} else {
		if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {

			//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
			$installer->getConnection()->addColumn(
					$installer->getTable('sales/order_payment'),
					$attributeId,
					'varchar(255)'
			);
		}
	}
}

$installer->endSetup();