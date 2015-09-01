<?php

$installer = $this;

$installer->startSetup();

$stores = Mage::getModel('core/store')->getCollection();

//$option['value'][optionKey][store id] = 'Option Label';
$option['value']['print'][0] = 'Print';
$option['value']['pdf'][0] = 'Pdf';
$option['value']['excel'][0] = 'Excel';


foreach($stores->getItems() as $store)
{
	//echo "<pre>"; var_dump($store->getName()); 
	$option['value']['print'][$store->getId()] = 'Print';
	$option['value']['pdf'][$store->getId()] = 'Pdf';
	$option['value']['excel'][$store->getId()] = 'Excel';
}



$installer->addAttribute('catalog_product', 'artikel_art', array(
    'label' => 'Artikel Art',
    'input' => 'select',
	'type' => 'varchar',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'is_user_defined' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
	'source'=>'eav/entity_attribute_source_table',
    'default' => '',
	'option' => $option,
	'group' => 'General',
));


$installer->endSetup(); 