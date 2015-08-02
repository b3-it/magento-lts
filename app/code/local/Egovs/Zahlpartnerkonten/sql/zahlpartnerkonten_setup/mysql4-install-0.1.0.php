<?php
/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

//20121116::Frank Rochlitzer : Die Tabelle sollte nie gelöscht werden, falls sie schon existiert!!!
if (!$installer->tableExists($installer->getTable('zpkonten/pool'))) {
	$installer->run("
		-- DROP TABLE IF EXISTS {$this->getTable('zahlpartnerkonten_pool')};
		CREATE TABLE {$this->getTable('zahlpartnerkonten_pool')} (
		  `zpkonten_pool_id` int(11) unsigned NOT NULL auto_increment,
		  `kassenzeichen` varchar(255) NOT NULL default '',
		  `mandant` varchar(255) NOT NULL default '',
		  `bewirtschafter` varchar(255) NOT NULL default '',
		  `customer_id` int(11) unsigned default NULL,
		  `customer_name` varchar(255) NOT NULL default '',
		  `customer_company` varchar(255) NOT NULL default '',
		  `customer_street` varchar(255) NOT NULL default '',
		  `customer_city` varchar(255) NOT NULL default '',
		  `customer_postcode` varchar(255) NOT NULL default '',
		  `last_payment` varchar(255) NOT NULL default '',
		  `currency` varchar(255) NOT NULL default '',
		  `status` smallint(6) NOT NULL default '0',
		  `created_time` datetime NULL,
		  `update_time` datetime NULL,
		  `status_update_time` datetime NULL,
		  PRIMARY KEY (`zpkonten_pool_id`),
		  FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer/entity')}`(`entity_id`) ON DELETE SET NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->getAttribute('customer', Egovs_Zahlpartnerkonten_Helper_Data::ATTRIBUTE_USE_ZPKONTO)) {
	$installer->addAttribute('customer', Egovs_Zahlpartnerkonten_Helper_Data::ATTRIBUTE_USE_ZPKONTO, array(
	    'label'   => 'Zahlpartnerkonto benutzen',
		'input' => 'select',
		'type' => 'int',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => true,
		'source' => 'eav/entity_attribute_source_boolean',
	    'default' => '1',
		'position' => 111,
		'group' => 'general',
		'is_required' => false,
		'user_defined' => false,
	));
	
	
	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms(Egovs_Zahlpartnerkonten_Helper_Data::ATTRIBUTE_USE_ZPKONTO, array('adminhtml_only' => true));
	}
}
/*
if (!$installer->getAttribute('customer', 'zpkonto_id')) {
	$installer->addAttribute('customer', 'zpkonto_id', array(
		'type' => 'int',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => false,
	    'default' => '0',
		'required' => false,
	));

	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms('zpkonto_id', array('adminhtml_only' => true));
	}
}
*/
/*
if (!$installer->getAttribute('customer', 'zpkonto_kassenzeichen')) {
	$installer->addAttribute('customer', 'zpkonto_kassenzeichen', array(
		'type' => 'int',
		'label'   => 'Kassenzeichen Zahlpartnerkonto',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => true,
	    'default' => '0',
		'disabled' => true,
		'position' => 112,
		'required' => false,
		//'source' => 'zpkonten/customer_attribute_source_pool',
		//'backend' => 'zpkonten/customer_attribute_backend_pool',
		'is_required' => false,
	));

	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms('zpkonto_kassenzeichen', array('adminhtml_only' => true));
	}
}
*/
$installer->endSetup(); 