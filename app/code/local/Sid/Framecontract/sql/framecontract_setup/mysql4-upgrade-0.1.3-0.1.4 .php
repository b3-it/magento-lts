<?php

$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('framecontract_los')))
{
	$installer->run("
		-- DROP TABLE IF EXISTS {$this->getTable('framecontract_los')};
		CREATE TABLE {$this->getTable('framecontract_los')} (
		`los_id` int(11) unsigned NOT NULL auto_increment,
		`framecontract_contract_id` int(11) unsigned NOT NULL,
		`title` varchar(255) NOT NULL default '',
		`note` varchar(1024) NOT NULL default '',
		`status` smallint(6) NOT NULL default '0',
		`key` varchar(255) NOT NULL default '',
		FOREIGN KEY (`framecontract_contract_id`) REFERENCES {$this->getTable('framecontract_contract')} (framecontract_contract_id) ON DELETE CASCADE,
		PRIMARY KEY (`los_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

$installer->addAttribute('catalog_product', 'framecontract_los', array(
		'label'        => 'Rahmenvertrag / Los',
		'input' => 'select',
		'type' => 'int',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
		'visible' => true,
		'source' => 'framecontract/source_attribute_lose',
		'default' => '0',
		'input_renderer'    => 'framecontract/adminhtml_widget_los',
));


$installer->run("
	ALTER TABLE {$this->getTable('framecontract_contract')} ADD `store_id` int default 0 ");

$installer->endSetup();