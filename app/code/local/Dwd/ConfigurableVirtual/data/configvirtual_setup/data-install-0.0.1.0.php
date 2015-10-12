<?php
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$fieldList = array(
    'price',
    'special_price',
    'special_from_date',
    'special_to_date',
    'minimal_price',
    'cost',
    'tier_price',
	'tax_class_id'
);

// make these attributes applicable to downloadable products
foreach ($fieldList as $field) {
    $applyTo = explode(',', $installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to'));
    if (!in_array(Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL, $applyTo)) {
        $applyTo[] = Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL;
        $installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to', implode(',', $applyTo));
    }
}
 
