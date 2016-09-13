<?php

$installer = $this;

$installer->startSetup();

$fields = array('KoRe_1_KST' => 'KoRe_1 Kostenstelle', 'KoRe_2_KTR' => 'KoRe_2 Kostenträger', 'KoRe_4' => 'KoRe_4 Haushalt' );

foreach($fields as $field=>$name)
{
	if (!$installer->getAttribute('catalog_product', $field)) {
		$installer->addAttribute('catalog_product', $field, array(
				'label' => $name,
				'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
				'visible' => false,
				//'required' => true,
				'is_user_defined' => true,
				'searchable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'visible_in_advanced_search' => false,
				'default' => '1',
				//'option' => $option,
				'group' => 'General',
				//'apply_to' => Mage_Catalog_Model_Product_Type::TYPE_SIMPLE, Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL,
		));
	}
}
$installer->endSetup(); 