<?php
//$configData = Mage::getConfig()->getNode('default/config_german')->asArray();

$installer = $this;
$installer->startSetup();

$installer->addAttribute('catalog_product', 'infotext_block', array(
		'label' => 'Checkout Info Text',
		'input' => 'select',
		'type' => 'varchar',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => false,
		'user_defined' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'source'=>'mpcheckout/config_source_info_block',
		'default' => '',
		'group' => 'General'
));

$installer->addAttribute('catalog_product', 'infotext_block_checkbox', array(
		'label' => 'Checkout Info Text Checkbox ',
		'input' => 'select',
		'type' => 'int',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => false,
		'user_defined' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'source' => 'eav/entity_attribute_source_boolean',
		'default' => '0',
		'group' => 'General'
));

$installer->addAttribute('catalog_category', 'infotext_block', array(
		'label' => 'Checkout Info Text',
		'input' => 'select',
		'type' => 'varchar',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => false,
		'user_defined' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'source'=>'mpcheckout/config_source_info_block',
		'default' => '',
		'group' => 'General'
));

$installer->addAttribute('catalog_category', 'infotext_block_checkbox', array(
		'label' => 'Checkout Info Text Checkbox ',
		'input' => 'select',
		'type' => 'int',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => false,
		'user_defined' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'source' => 'eav/entity_attribute_source_boolean',
		'default' => '0',
		'group' => 'General'
));

$installer->endSetup();