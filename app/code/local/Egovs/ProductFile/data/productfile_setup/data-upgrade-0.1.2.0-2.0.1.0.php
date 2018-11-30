<?php
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;
$connection = $installer->getConnection();

$installer->startSetup();

$entityTypeId = $installer->getEntityTypeId(Mage_Catalog_Model_Product::ENTITY);
$attributeId = $installer->getAttributeId($entityTypeId, 'productfiledescription');

if ($attributeId) {
	$installer->updateAttribute($entityTypeId, $attributeId, 'frontend_input', 'media_image');
	$installer->updateAttribute($entityTypeId, $attributeId, 'is_visible_on_front', true);
	$installer->updateAttribute($entityTypeId, $attributeId, 'frontend_model', 'productfile/entity_attribute_frontend_productfile');
}
$installer->endSetup();