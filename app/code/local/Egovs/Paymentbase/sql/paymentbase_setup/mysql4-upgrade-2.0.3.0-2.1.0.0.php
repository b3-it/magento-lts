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

$epayblAttributes = array('haushaltsstelle', 'objektnummer', 'objektnummer_mwst', 'href', 'href_mwst', 'buchungstext', 'buchungstext_mwst');
foreach ($epayblAttributes as $attributeCode) {
    /**
     *
     * @var Mage_Eav_Model_Attribute $attribute
     */
    $attributeId = $installer->getAttributeId(Mage_Catalog_Model_Product::ENTITY, $attributeCode);
    if (!$attributeId) {
        continue;
    }
    $installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, $attributeCode, 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_WEBSITE);
}

$installer->endSetup();