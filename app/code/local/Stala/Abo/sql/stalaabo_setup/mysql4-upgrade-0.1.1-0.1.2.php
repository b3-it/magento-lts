<?php

$installer = $this;

$installer->startSetup();
$installer->addAttribute('order', 'is_abo', array(
    'label'        => 'Is Abo Order',
    'visible'      => 1,
    'required'     => 0,
    'position'     => 1,
	'type'	=> 'int',
));



$installer->addAttribute('customer', 'abo_print_note1', array(
    'label' => 'Abo Print Note 1',
	'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
	'required' => false,
));


$installer->addAttribute('customer', 'abo_print_note2', array(
    'label' => 'Abo Print Note 2',
	'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
	'required' => false,
));


$installer->endSetup(); 