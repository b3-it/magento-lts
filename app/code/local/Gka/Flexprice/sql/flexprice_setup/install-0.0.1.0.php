<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();



$fieldList = array(
		'haushaltsstelle',
		'objektnummer',
		'objektnummer_mwst',
		'href',
		'href_mwst',
		'buchungstext',
		'buchungstext_mwst'
);

foreach ($fieldList as $field) {
    $applyTo = explode(',', $installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to'));
    $applyTo[] = Gka_Flexprice_Model_Product_Type::TYPE_CODE;
    $installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to', implode(',', $applyTo));
}

if (!$installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'allow_price_zero')) {
	$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'allow_price_zero', array(
			'label' => 'Preis 0 Euro erlauben',
			'input' => 'select',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => true,
			//'required' => true,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'source'    => 'eav/entity_attribute_source_boolean',
			'default' => '1',
			//'option' => $option,
			'group' => 'General',
			'apply_to' => Gka_Flexprice_Model_Product_Type::TYPE_CODE,
	));
	$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'allow_price_zero', 'apply_to', Gka_Flexprice_Model_Product_Type::TYPE_CODE);
}




$installer->endSetup();