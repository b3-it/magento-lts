<?php

$installer = $this;

$installer->startSetup();


$installer->addAttribute('catalog_product', 'minority_interest', array(
    'label' => 'Minority Interest',
    'input' => 'select',
    'type' => 'varchar',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => true,
    'is_user_defined' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'source'  => 'gka_reports/attribute_source_boolean',
    'default' => '0',
    //'option' => $option,
    'group' => 'General',
));


/*
$columnName = 'minority_interest';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
			'nullable' => true,
			'length' => 48,
			'default' => null,
            'comment' => $columnName
	));
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
			'nullable' => true,
			'length' => 48,
			'default' => null,
            'comment' => $columnName
	));
}
*/

$installer->endSetup(); 