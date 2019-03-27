<?php

/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

/**
 * Create table 'internalpayid/payid'
 */
if (!$installer->tableExists($installer->getTable('internalpayid/payid'))) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable('internalpayid/payid'))
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity' => true,
            'unsigned' => true,
            'nullable' => false,
            'primary' => true,
            'autoincrement' => true,
        ), 'ID')
        ->addColumn('internal_payid', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'id aus fachverfahren')
        ->addColumn('order_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => true,
            'default' => '0',
        ), 'Order Item ID')
        ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'title')
        ->addColumn('client', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(), 'client')
        ->addForeignKey(
            $installer->getFkName('internalpayid/specialized_procedure_client', 'order_item_id', 'sales/order_item', 'item_id'),
            'order_item_id', $installer->getTable('sales/order_item'), 'item_id',
            Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE
        )
        ->setComment('Payment Indentification Table');


    $installer->getConnection()->createTable($table);
}

if (!$installer->tableExists($installer->getTable('internalpayid/specialized_procedure_client')))
{
    $installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('internalpayid/specialized_procedure_client')};
	CREATE TABLE {$installer->getTable('internalpayid/specialized_procedure_client')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
      `title` varchar(128) default '',
      `client` varchar(128) default '',
      `visible_in_stores` varchar(128) default '',
      `pay_operator` varchar(128) default '',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

$fieldList = array(
		'haushaltsstelle',
		'objektnummer',
		'objektnummer_mwst',
		'href',
		'href_mwst',
		'buchungstext',
		'buchungstext_mwst'
);

foreach ($fieldList as $field) {
    $applyTo = explode(',', $installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to'));
    $applyTo[] = 'internalpayid';
    $installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to', implode(',', $applyTo));
}




$attributeId = 'internal_payid';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_item'), $attributeId)) {
    $installer->getConnection()->addColumn(
        $installer->getTable('sales/order_item'),
        $attributeId,
        'varchar(255) default null'
    );
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_item'), $attributeId)) {
    $installer->getConnection()->addColumn(
        $installer->getTable('sales/quote_item'),
        $attributeId,
        'varchar(255) default null'
    );
}


$installer->endSetup();