<?php

/** @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();


if (!$installer->tableExists($installer->getTable('ibewi/kostentraeger_attribute')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('ibewi/kostentraeger_attribute')};
	CREATE TABLE {$installer->getTable('ibewi/kostentraeger_attribute')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `title` varchar(255) default '',
	  `value` varchar(128) default '',
	  `standard` smallint(6) unsigned default '0',
	  `pos` smallint(6) unsigned default '0',
	  PRIMARY KEY (`id`) 
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
	

	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (1,'Flugwetter-Informationsdienste / VFR-Kunden','30 99 05 06000 G',0);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (2,'Nutzungslizenzen pc_met Internet Service, FlugMet, Heliportal','30 06 01 05S00 G',0);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (3,'Spezialberatung, Consulting und Schulung für Luftfahrtdienstleister und Piloten','30 99 05 04000 G',0);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (4,'AGROWETTER','30 06 05 10S00 G',1);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (5,'Lizenzen SEEWIS','30 06 02 02S00 G',0);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (6,'Allgemeine Straßenwettervorhersagen (SWIS)','30 04 01 02000 G',0);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (7,'Detaillierte Straßengebietswettervorhersagen (SWIS)','30 04 01 03000 G',0);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (8,'WESTE (Wetterdaten und Statistiken express)','30 01 03 07000 G',0);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (9,'Allgemeine statistische Auswertungen KLIMA','30 08 01 01S00 G',0);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (10,'Witterungsberichte','30 10 01 04S00 G',0);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (11,'Geburtstagswetterkarten','30 99 01 01000 Z',0);");
	$installer->run("INSERT INTO {$installer->getTable('ibewi/kostentraeger_attribute')} (pos,title,value,standard) VALUES (12,'Schriftenreihen der Meteorologie und Leitfäden für die Ausbildung','30 10 03 01S00 G',0);");
	
	
}

$installer->addAttribute('catalog_product', 'kostentraeger', array(
		'label' => 'Kostenträger',
		'input' => 'select',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'default' => '',
		'source'    => 'ibewi/entity_attribute_source_kostentraeger',
));


$columnName = 'kostentraeger';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
			'nullable' => true,
			'length' => 48,
			'default' => null,
			'comment' => 'kostentraeger'
	));
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
			'nullable' => true,
			'length' => 48,
			'default' => null,
			'comment' => 'kostentraeger'
	));
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/invoice_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/invoice_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
			'nullable' => true,
			'length' => 48,
			'default' => null,
			'comment' => 'kostentraeger'
	));
}

$installer->endSetup(); 