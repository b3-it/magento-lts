<?php


/** @var $this Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();


if (!$installer->getAttribute('customer', 'allow_shapefile')) {
	$installer->addAttribute('customer', 'allow_shapefile', array(
			'label' => 'Shapefiles',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => false,
			'required' => false,
	));
}
$installer->endSetup();