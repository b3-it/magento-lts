<?php

$installer = $this;

$installer->startSetup();

/*
if (!$installer->getConnection()->isTableExists($installer->getTable('userstore'))) {
	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('userstore')};
	CREATE TABLE {$this->getTable('userstore')} (
	  `userstore_id` int(11) unsigned NOT NULL auto_increment,
	  `user_id` int(11) unsigned NOT NULL,
	  `store_id` int(11) unsigned NOT NULL,
	  `pos` int(11) default 0,
	  FOREIGN KEY (`user_id`) REFERENCES `{$this->getTable('customer/customer')}`(`entity_id`) ON DELETE CASCADE
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
	  PRIMARY KEY (`userstore_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	    ");
}
*/

if (!$installer->getAttribute('customer','allowed_stores')) {
	$installer->addAttribute('customer', 'allowed_stores', array(
			'label' => 'Erlaubte Stores',
			'type' => 'text',
    		'input' => 'multiselect',
    		'source' => 'userstore/entity_attribute_source_allowedstores',
    		'backend' => 'userstore/entity_attribute_backend_allowedstores',
    		//'frontend' => 'netzarbeiter_groupscatalog2/entity_attribute_frontend_customergroups',
    		//'input_renderer' => 'netzarbeiter_groupscatalog2/adminhtml_data_form_customergroup',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			//'frontend' => 'paymentbase/customer_attribute_frontend_readonly',
			'visible' => true,
			'group' => 'general',
			'required' => true,
			'user_defined' => false,
			'default' => '0',
			'sort_order' => 100,
	));

	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms('allowed_stores', array('adminhtml_only' => true));
	}
}

$installer->endSetup(); 