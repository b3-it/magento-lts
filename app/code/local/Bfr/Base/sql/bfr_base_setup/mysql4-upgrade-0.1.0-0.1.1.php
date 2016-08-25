<?php

$installer = $this;

$installer->startSetup();

if (!$installer->getAttribute('catalog_product', 'event_date')) {
    $installer->addAttribute('catalog_product', 'event_date', array(
        'label'                   => 'Event Date',
        'input'                   => 'text',
        'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
        'visible'                 => true,
        'required'                => false,
        'used_in_product_listing' => true
    ));
}

$installer->endSetup();