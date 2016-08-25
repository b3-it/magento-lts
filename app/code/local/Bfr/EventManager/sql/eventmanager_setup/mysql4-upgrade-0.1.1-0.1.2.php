<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$installer->addAttribute('customer_address', 'titel', array(
		'label'			=> 'Academic Titel',
		'global' 		=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'      	=> 1,
		'required'     	=> 0,
		'position'     	=> 1,
		'sort_order'   	=> 31,
));


$installer->addAttribute('customer_address', 'position', array(
		'label'        	=> 'Position',
		'global' 		=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'      	=> 1,
		'required'     	=> 0,
		'position'     	=> 1,
		'sort_order'   	=> 32,
));

if (!$installer->getConnection()->tableColumnExists($installer->getTable('eventmanager/participant'), 'title')) {
	$installer->run("
			ALTER TABLE {$installer->getTable('eventmanager/participant')}
			ADD COLUMN title varchar(255) NOT NULL default '';
			");
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('eventmanager/participant'), 'position')) {
	$installer->run("
			ALTER TABLE {$installer->getTable('eventmanager/participant')}
			ADD COLUMN position varchar(255) NOT NULL default '';
			");
}


$installer->endSetup();