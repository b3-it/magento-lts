<?php

$installer = $this;

$installer->startSetup();


$installer->addAttribute('customer', 'company', array(
    'label' => 'Company Name',
	'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
	'required' => false,
));
/*
$installer->addAttribute('order', 'company', array(
    'label' => 'Company Name',
	'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
	'required' => false,
));
*/

$installer->endSetup();
 