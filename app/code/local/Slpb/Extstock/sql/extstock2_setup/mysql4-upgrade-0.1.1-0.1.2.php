<?php

$installer = $this;

$installer->startSetup();

$installer->addAttribute('catalog_product', 'packaging_size', array(
		'label'       	 	=> 'Stück pro VPE',
		'input' 			=> 'text',
		'type' 				=> 'varchar',
		'class'				=> 'validate-digits',
		'global' 			=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' 			=> true,
		'required' 			=> true,
		'user_defined' 		=> true,
		'searchable' 		=> false,
		'comparable' 		=> false,
		'visible_on_front' 	=> false,
		'visible_in_advanced_search' => false,
		'default' 			=> '1',
));



$installer->run("ALTER TABLE extstock2_stock_journal ADD `deliveryorder_increment_id` int(10) unsigned default 0");

$installer->endSetup(); 