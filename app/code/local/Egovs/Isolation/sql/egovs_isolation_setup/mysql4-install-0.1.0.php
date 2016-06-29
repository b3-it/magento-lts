<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation Installer
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('isolation/store_user_relation'))) {
	$table = $installer->getConnection()
	    ->newTable($installer->getTable('isolation/store_user_relation'))
	    ->addColumn('relation_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
	        'identity'  => true,
	        'unsigned'  => true,
	        'nullable'  => false,
	        'primary'   => true,
	        ), 'Entity ID')
	    ->addColumn('store_group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Store')
	    ->addForeignKey('fk_relation_store_isolation','store_group_id', $installer->getTable('core/store_group'), 'group_id',
	        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	    ->addColumn('user_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'User')
	    ->addForeignKey('fk_relation_user_isolation','user_id', $installer->getTable('admin/user'), 'user_id',
	        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
	     ;
	$installer->getConnection()->createTable($table);
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('catalog/product'), 'store_group')) {
	$installer->run("ALTER TABLE `{$installer->getTable('catalog/product')}`  ADD `store_group` int default 0");
}

$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'store_group', array(
		'type'                    => 'static',
		'input'                   => '',
		'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'                 => false,
		'user_defined'            => false,
		'default'                 => '0',
		'searchable'              => false,
		'filterable'              => false,
		'comparable'              => false,
		'visible_on_front'        => false,
		
));



$columnName = 'store_group';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/quote_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			'nullable' => true,
			'length' => 48,
			'default' => null,
			'comment' => 'store_group'
	));
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			'nullable' => true,
			'length' => 48,
			'default' => null,
			'comment' => 'store_group'
	));
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/invoice_item'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('sales/invoice_item'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			'nullable' => true,
			'length' => 48,
			'default' => null,
			'comment' => 'store_group'
	));
}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('newsletter/template'), $columnName)) {
	$installer->getConnection()->addColumn($installer->getTable('newsletter/template'), $columnName, array(
			'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
			'nullable' => true,
			'length' => 48,
			'default' => null,
			'comment' => 'store_group'
	));
}


$installer->endSetup(); 
