<?php

/** @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'eventfeed_export')) {
    $installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'eventfeed_export', array(
        'label' => 'Show in Content Feed',
        'input' => 'select',
        'type' => 'int',
        'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
        'visible' => true,
        //'required' => true,
        'user_defined' => false,
        'searchable' => false,
        'comparable' => false,
        'visible_on_front' => false,
        'visible_in_advanced_search' => false,
        'source'    => 'eav/entity_attribute_source_boolean',
        'default' => '0',
        //'option' => $option,
        'group' => 'General',
        'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
    ));
}

// product file need to be in general or else it did fail in admin
if ($installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, 'productfile')) {
    $installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'productfile', 'is_user_defined', false);
    $installer->addAttributeToSet(Mage_Catalog_Model_Product::ENTITY, 'Default', 'General', 'productfile');
}

$installer->endSetup();