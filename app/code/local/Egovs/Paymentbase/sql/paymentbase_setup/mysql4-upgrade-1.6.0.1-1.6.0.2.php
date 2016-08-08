<?php
/**
 * Eigener Reiter für ePayBL
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2016 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 * @var Egovs_Paymentbase_Model_Resource_Setup $installer
 */
$installer = $this;

$installer->startSetup();

$epayblSettings = 'ePayBL Settings';
if (!$installer->getAttributeGroup(Mage_Catalog_Model_Product::ENTITY, 'Default', $epayblSettings)) {
	// Gruppe soll direkt nach Preis angezeigt werden (2)
	$installer->addAttributeGroup(Mage_Catalog_Model_Product::ENTITY, 'Default', $epayblSettings, 2);
	
	$epayblAttributes = array('haushaltsstelle', 'objektnummer', 'objektnummer_mwst', 'href', 'href_mwst', 'buchungstext', 'buchungstext_mwst');
	foreach ($epayblAttributes as $attributeId) {
		$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeId, 'group', $epayblSettings);
	}
}


$installer->endSetup();