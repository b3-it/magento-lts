<?php
/** @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$fields = array('activate_time' => 'Aktivieren Ab', 'deactivate_time' => 'Deaktivieren Ab');

foreach($fields as $field=>$name)
{
	if (!$installer->getAttribute('catalog_product', $field)) {
		$installer->addAttribute('catalog_product', $field, array(
				'label' => $name,
				'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
				'visible' => true,
				'required' => false,
				'is_user_defined' => true,
				'searchable' => false,
				'comparable' => false,
				'visible_on_front' => false,
				'visible_in_advanced_search' => false,
				'default' => '1',
				//'option' => $option,
				'type' => 'datetime',
				'input' => 'datetime',
				'group' => 'General',
				//'apply_to' => Mage_Catalog_Model_Product_Type::TYPE_SIMPLE, Mage_Catalog_Model_Product_Type::TYPE_VIRTUAL,
		));
	}
}

$installer->endSetup(); 