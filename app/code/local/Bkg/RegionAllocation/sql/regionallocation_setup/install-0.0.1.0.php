<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();


if (!$installer->tableExists($installer->getTable('regionallocation/koenigsteinerschluessel_kst')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('regionallocation/koenigsteinerschluessel_kst')};
	   CREATE TABLE {$installer->getTable('regionallocation/koenigsteinerschluessel_kst')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `name` varchar(128) default '',
	  `active` smallint(6) default '0',
	  `active_from` datetime default '0000-00-00',
	  `active_to` datetime default '0000-00-00',
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('regionallocation/koenigsteinerschluessel_kst_value')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('regionallocation/koenigsteinerschluessel_kst_value')};
	   CREATE TABLE {$installer->getTable('regionallocation/koenigsteinerschluessel_kst_value')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `kst_id` int(11) unsigned NOT NULL,
	  `region` varchar(128) default '',
	  `has_tax` smallint(6) default '0',
	  `portion` DECIMAL(12,8) default '0.0',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`kst_id`) REFERENCES `{$this->getTable('regionallocation/koenigsteinerschluessel_kst')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}





/**
 * Create table 'regionallocation/purchased'
 */
if (!$installer->tableExists($installer->getTable('regionallocation/purchased')))
{
	$table = $installer->getConnection()
		->newTable($installer->getTable('regionallocation/purchased'))
		->addColumn('purchased_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'identity'  => true,
				'unsigned'  => true,
				'nullable'  => false,
				'primary'   => true,
				), 'Purchased ID')
		->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				), 'Order ID')
		->addColumn('order_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
				'unsigned'  => true,
				'nullable'  => false,
				), 'Order Item ID')
		->addColumn('region', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
				), 'Region')
		->addColumn('portion', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(12,8), array(
				), 'Region Portion')
		->addColumn('amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(10,4), array(
				), 'Region Amount (Netto Price)')
		->addColumn('tax_rate', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(10,4), array(
				), 'Region Tax Rate')
		->addColumn('tax_amount', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(10,4), array(
				), 'Region Tax Amount')
		->addColumn('total', Varien_Db_Ddl_Table::TYPE_DECIMAL, array(10,4), array(
				), 'Region Total (Brutto Price)')
		->addIndex($installer->getIdxName('regionallocation/purchased', 'order_id'), 'order_id')
		->addIndex($installer->getIdxName('regionallocation/purchased', 'order_item_id'), 'order_item_id')
		->addForeignKey(
			$installer->getFkName('regionallocation/purchased', 'order_id', 'sales/order', 'entity_id'),
			'order_id', $installer->getTable('sales/order'), 'entity_id',
			Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
		)
		->addForeignKey(
				$installer->getFkName('regionallocation/purchased', 'order_item_id', 'sales/order_item', 'item_id'),
				'order_item_id', $installer->getTable('sales/order_item'), 'item_id',
				Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
				)
		
	;
	$installer->getConnection()->createTable($table);
}




$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), 'kst_name',  array(
            'type' => Varien_Db_Ddl_Table::TYPE_TEXT,
            'size'     => 128,
			'comment' =>'Name Königsteineschlüssel'
        ));


$installer->getConnection()->addColumn($installer->getTable('sales/order_item'), 'kst_id',  array(
		'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
		'unsigned'  => true,
		'nullable'  => true,
		//'default'   => 'NULL',
		'comment' =>'ID Königsteineschlüssel'
		));

$installer->getConnection()->addForeignKey($installer->getFkName( 'sales/order_item', 'item_id','regionallocation/koenigsteinerschluessel_kst', 'id'),
			$installer->getTable('sales/order_item'), 'kst_id', 
			$installer->getTable('regionallocation/koenigsteinerschluessel_kst'),'id', 
			Varien_Db_Ddl_Table::ACTION_SET_NULL);

$installer->endSetup();