<?php

$installer = $this;

$installer->startSetup();



if (!$installer->getAttribute('catalog_product', 'name_prefix')) {
	$installer->addAttribute('catalog_product', 'name_prefix', array(
			'label' => 'Name Prefix',
			'input' => 'text',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => true,
			'required' => false,
			'used_in_product_listing'    => true,
	));

	//$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'name_prefix', 'apply_to', Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE);
}



$installer->endSetup(); 