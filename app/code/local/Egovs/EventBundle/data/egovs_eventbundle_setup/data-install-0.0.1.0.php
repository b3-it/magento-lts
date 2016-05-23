<?php
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$fieldList = array(
	'price',
	'special_price',
	'special_from_date',
	'special_to_date',
	'cost',
	'weight',
	'tier_price',
	'minimal_price',
	'country_of_manufacture',
	'msrp_enabled',
	'msrp_display_actual_price_type',
	'msrp',
	'tax_class_id',
	'price_type',
	'sku_type',
	'weight_type',
	'price_view',
	'shipment_type'
);

// make these attributes applicable to downloadable products
foreach ($fieldList as $field) {
    $applyTo = explode(',', $installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to'));
    if (!in_array(Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE, $applyTo)) {
        $applyTo[] = Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE;
        $installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to', implode(',', $applyTo));
    }
}
 
