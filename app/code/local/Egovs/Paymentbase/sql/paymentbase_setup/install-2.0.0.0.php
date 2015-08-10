<?php
/**
 *
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package         Egovs_Ready
 * @name            Egovs_Ready_Helper_Data
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/* @var $this Egovs_Paymentbase_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/*
 * Falls user_defined => true benutzt wird, muss ein Attributset bzw. eine Gruppe angegeben werden.
 * Falls user_defined => false so wird es in alle Attributsets integriert (Gruppe: General)
*/

/*
 * ========================= Attribute und Spalten hinzufügen ===========================================================================================
 */
$entityTypeId = 'order_payment';
$attributeId = 'kassenzeichen';

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {
	//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/order_payment'),
			$attributeId,
			'varchar(255)'
	);
}
$attributeId = 'saferpay_transaction_id';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {
	//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/order_payment'),
			$attributeId,
			'varchar(255)'
	);
}
$attributeId = 'paywithinxdays';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {
	$installer->getConnection()->addColumn(
		$installer->getTable('sales/order_payment'),
		$attributeId,
		'integer default 14'
	);
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_payment'), $attributeId)) {
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/quote_payment'),
			$attributeId,
			'int(10) unsigned default 0'
	);
}

$attributeId = Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID;
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {
	//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/order_payment'),
			$attributeId,
			'varchar(255)'
	);
}

$epayblSettings = 'ePayBL Settings';
// Gruppe soll direkt nach Preis angezeigt werden (2)
$installer->addAttributeGroup(Mage_Catalog_Model_Product::ENTITY, 'Default', $epayblSettings, 2);
$entityTypeId = Mage_Catalog_Model_Product::ENTITY;
$attributeId = 'haushaltsstelle';
$installer->addAttribute($entityTypeId, $attributeId, array(
		'group' => $epayblSettings,
		'label' => 'Haushaltsstelle',
		'input' => 'select',
		'source' => 'paymentbase/attributes_source_'.str_replace('_','' , $attributeId),
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'default' => '',
));

$attributeId = 'objektnummer';
$installer->addAttribute($entityTypeId, $attributeId, array(
		'group' => $epayblSettings,
		'label' => 'Objektnummer',
		'input' => 'select',
		'source' => 'paymentbase/attributes_source_'.str_replace('_','' , $attributeId),
		'backend' => 'paymentbase/attributes_backend_objektnummerhhstelle',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => false,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'default' => '',
));

$attributeId = 'objektnummer_mwst';
$installer->addAttribute($entityTypeId, $attributeId, array(
		'group' => $epayblSettings,
		'label' => 'Objektnummer MwSt',
		'input' => 'select',
		'source' => 'paymentbase/attributes_source_'.str_replace('_','' , $attributeId),
		'backend' => 'paymentbase/attributes_backend_objektnummerhhstelle',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => false,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'default' => '',
));

$attributeId = 'href';
$installer->addAttribute($entityTypeId, $attributeId, array(
		'group' => $epayblSettings,
		'label' => 'HREF',
		'input' => 'select',
		'source' => 'paymentbase/attributes_source_'.str_replace('_','' , $attributeId),
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'default' => '',
));

$attributeId = 'href_mwst';
$installer->addAttribute($entityTypeId, $attributeId, array(
		'group' => $epayblSettings,
		'label' => 'HREF MwSt',
		'input' => 'select',
		'source' => 'paymentbase/attributes_source_'.str_replace('_','' , $attributeId),
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'default' => '',
));

$attributeId = 'buchungstext';
$installer->addAttribute($entityTypeId, $attributeId, array(
		'group' => $epayblSettings,
		'label' => 'Buchungstext',
		'input' => 'select',
		'source' => 'paymentbase/attributes_source_'.str_replace('_','' , $attributeId),
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'default' => '',
));

$attributeId = 'buchungstext_mwst';
$installer->addAttribute($entityTypeId, $attributeId, array(
		'group' => $epayblSettings,
		'label' => 'Buchungstext MwSt',
		'input' => 'select',
		'source' => 'paymentbase/attributes_source_'.str_replace('_','' , $attributeId),
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'default' => '',
));

if (!$installer->getAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID)) {
	$installer->addAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID, array(
			'label' => 'ePayBL Customer ID',
			'type' => 'varchar',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'frontend' => 'paymentbase/customer_attribute_frontend_readonly',
			'visible' => true,
			'group' => 'general',
			'required' => false,
			'user_defined' => false,
			'default' => '0',
			'sort_order' => 10,
	));

	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID, array('adminhtml_only' => true));
	}
}

if (!$installer->getAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID)) {
	$installer->addAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, array(
			'label' => 'SEPA Mandate ID',
			'type' => 'varchar',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'input' => 'text',
			'frontend' => 'paymentbase/customer_attribute_frontend_mandate',
			'visible' => true,
			'group' => 'general',
			'required' => false,
			'user_defined' => false,
			'default' => '',
			'sort_order' => 11,
	));

	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, array('adminhtml_only' => true));
	}
}

if (!$installer->getAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_ADDITIONAL)) {
	$installer->addAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_ADDITIONAL, array(
			'label' => 'SEPA Mandate Additional Data',
			'type' => 'varchar',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'input' => 'text',
			'visible' => true,
			'required' => false,
			'user_defined' => false,
			'default' => '',
			'sort_order' => 11,
	));
}
/*
 * ========================= Tabellen erstellen ===========================================================================================
 */
$installer->run("
		DROP TABLE IF EXISTS {$this->getTable('paymentbase/transactions')};
		CREATE TABLE {$this->getTable('paymentbase/transactions')} (
			`bkz` varchar(255) NOT NULL,
			`quote_id` int(10) default NULL,
			`order_id` int(10) default NULL,
			`created_at` datetime NOT NULL default '0000-00-00 00:00:00',
			`updated_at` datetime NOT NULL default '0000-00-00 00:00:00',
			`payment_method` varchar(255) default NULL,
			PRIMARY KEY (`bkz`)
		) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;
		"
);

$installer->run("
		DROP TABLE IF EXISTS {$this->getTable('egovs_paymentbase_localparams')};
		CREATE TABLE {$this->getTable('egovs_paymentbase_localparams')} (
			`paymentbase_localparams_id` int(11) unsigned NOT NULL auto_increment,
			`param_id` int(11) unsigned NOT NULL,
			`title` varchar(255) NOT NULL default '',
			`value` varchar(128) NOT NULL default '',
			`status` smallint(6) NOT NULL default '0',
			`priority` smallint(6) NOT NULL default '0',
			`lower` decimal(10,2) default 0,
			`upper` decimal(10,2) default 99999999.99,
			`customer_group_id` smallint(5) default -1,
			`payment_method` varchar(128) NOT NULL default '',
			`created_time` datetime NULL,
			`update_time` datetime NULL,
			PRIMARY KEY (`paymentbase_localparams_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	"
);

$installer->run("
		DROP TABLE IF EXISTS {$this->getTable('egovs_paymentbase_defineparams')};
		CREATE TABLE {$this->getTable('egovs_paymentbase_defineparams')} (
			`param_id` int(11) unsigned NOT NULL auto_increment,
			`title` varchar(255) NOT NULL default '',
			`ident` varchar(128) NOT NULL default '',
			PRIMARY KEY (`param_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	"
);

$installer->run("
		ALTER TABLE {$this->getTable('egovs_paymentbase_localparams')} ADD FOREIGN KEY (`param_id`) REFERENCES `{$this->getTable('egovs_paymentbase_defineparams')}`(`param_id`) ON DELETE CASCADE;
	"
);

if (!$installer->getConnection()->isTableExists($installer->getTable('egovs_paymentbase_haushaltsparameter'))) {
	$installer->run("
		-- DROP TABLE IF EXISTS {$this->getTable('egovs_paymentbase_haushaltsparameter')};
		CREATE TABLE {$this->getTable('egovs_paymentbase_haushaltsparameter')} (
			`paymentbase_haushaltsparameter_id` int(11) unsigned NOT NULL auto_increment,
			`title` varchar(255) NOT NULL default '',
			`value` varchar(255) NOT NULL default '',
			`type` smallint(6) NOT NULL default '0',
			`created_time` datetime NULL,
			`update_time` datetime NULL,
			PRIMARY KEY (`paymentbase_haushaltsparameter_id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	"
	);
}

if (!$installer->getConnection()->isTableExists($installer->getTable('egovs_paymentbase_objektnummer_hhstelle'))) {
	$installer->run("
		-- DROP TABLE IF EXISTS {$this->getTable('egovs_paymentbase_objektnummer_hhstelle')};
		CREATE TABLE {$this->getTable('egovs_paymentbase_objektnummer_hhstelle')} (
			`paymentbase_objektnummer_hhstelle_id` int(11) unsigned NOT NULL auto_increment,
			`objektnummer` int(11) unsigned NOT NULL,
			`hhstelle` int(11) unsigned NOT NULL,
			FOREIGN KEY (`objektnummer`) REFERENCES {$installer->getTable('egovs_paymentbase_haushaltsparameter')}(`paymentbase_haushaltsparameter_id`) ON DELETE CASCADE,
			FOREIGN KEY (`hhstelle`) REFERENCES {$installer->getTable('egovs_paymentbase_haushaltsparameter')}(`paymentbase_haushaltsparameter_id`) ON DELETE CASCADE,
			PRIMARY KEY (`paymentbase_objektnummer_hhstelle_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		"
	);
}

$tableName = 'paymentbase/sepa_mandate_history';
if (!$installer->tableExists($tableName)) {
	$table = $installer->getConnection()
		->newTable($installer->getTable($tableName))
		->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
					'identity'  => true,
					'unsigned'  => true,
					'nullable'  => false,
					'primary'   => true,
			), 'Entity ID')
		->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Kunden ID')
		->addColumn(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(), 'Mandatsreferenz')
		->addColumn(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID, Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(), 'epayBL Kundennummer')
		->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'Created at')
		->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'Updated at')
		->addIndex($installer->getIdxName($tableName, 'customer_id'), array('customer_id'))
		->addIndex($installer->getIdxName($tableName, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID), array(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID))
	;
	$installer->getConnection()->createTable($table);
}

$installer->endSetup();