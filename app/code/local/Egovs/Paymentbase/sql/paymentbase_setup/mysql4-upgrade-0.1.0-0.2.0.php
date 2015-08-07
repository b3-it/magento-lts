<?php

$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'buchungstext_mwst', array(
    'label' => 'Buchungstext MwSt',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '',
));

$installer->endSetup(); 