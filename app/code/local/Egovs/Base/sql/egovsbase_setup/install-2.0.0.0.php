<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();


$installer->addAttribute('customer', 'company', array(
		'label' => 'Company Name',
		'input' => 'text',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => false,
));

$installer->addAttribute('customer_address', 'company2', array(
		'label'			=> 'Company 2',
		'global' 		=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'      	=> 1,
		'required'     	=> 0,
		'position'     	=> 1,
		'sort_order'   	=> 31,
));


$installer->addAttribute('customer_address', 'company3', array(
		'label'        	=> 'Company 3',
		'global' 		=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'      	=> 1,
		'required'     	=> 0,
		'position'     	=> 1,
		'sort_order'   	=> 32,
));

$installer->addAttribute('order', 'owner', array(
		'label'        => 'Owner',
		'visible'      => 1,
		'required'     => 0,
		'input' 	   => 'text'
));

$installer->addAttribute('order', 'owner_phone', array(
		'label'        => 'Owner Telephone',
		'visible'      => 1,
		'required'     => 0,
		'input' 	   => 'text'
));

//mysql4-upgrade-0.1.9-0.1.10.php
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'owner')) {
	$installer->run("ALTER TABLE `{$installer->getTable('sales_flat_order')}`  ADD `owner` varchar(255) default NULL");
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'owner_phone')) {
	$installer->run("ALTER TABLE `{$installer->getTable('sales_flat_order')}`  ADD `owner_phone` varchar(255) default NULL");
}

$installer->addAttribute('order', 'printnote1', array(
		'label'        => 'Print Note 1',
		'visible'      => 1,
		'required'     => 0,
		'position'     => 1,
		'sort_order'   => 31,
		'type'		   => 'static'
));

$installer->addAttribute('order', 'printnote2', array(
		'label'        => 'Print Note 2',
		'visible'      => 1,
		'required'     => 0,
		'position'     => 1,
		'sort_order'   => 32,
		'type'		   => 'static'
));
//mysql4-upgrade-0.1.14-0.1.15.php
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'printnote1')) {
	$installer->run("ALTER TABLE `{$installer->getTable('sales/order')}`  ADD `printnote1` varchar(255) default NULL");
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'printnote2')) {
	$installer->run("ALTER TABLE `{$installer->getTable('sales_flat_order')}`  ADD `printnote2` varchar(255) default NULL");
}

$installer->addAttribute('customer_address', 'email', array(
		'label'        => 'e-Mail',
		'visible'      => 1,
		'required'     => 0,
		'position'     => 1,
));

$installer->addAttribute('customer_address', 'web', array(
		'label'        => 'Web',
		'visible'      => 1,
		'required'     => 0,
		'position'     => 1,
));

if (!$installer->getAttribute('customer', 'base_addrress')) {
	$installer->addAttribute('customer', 'base_address', array(
			'label' => 'Stammadresse',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => false,
			'required' => false,
	));
}

$attributeId = 'company2';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_address'), $attributeId)) {
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/order_address'),
			$attributeId,
			'varchar(255) default NULL'
	);
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_address'), $attributeId)) {
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/quote_address'),
			$attributeId,
			'varchar(255) default NULL'
	);
}
$attributeId = 'company3';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_address'), $attributeId)) {
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/order_address'),
			$attributeId,
			'varchar(255) default NULL'
	);
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_address'), $attributeId)) {
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/quote_address'),
			$attributeId,
			'varchar(255) default NULL'
	);
}
$attributeId = 'customer_company';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), $attributeId)) {
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/order'),
			$attributeId,
			'varchar(255) default NULL'
	);
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote'), $attributeId)) {
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/quote'),
			$attributeId,
			'varchar(255) default NULL'
	);
}

$attributeId = 'phone';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('admin/user'), $attributeId)) {
	$installer->getConnection()->addColumn(
			$installer->getTable('admin/user'),
			$attributeId,
			"varchar(128) not NULL default ''"
	);
}

$installer->run("ALTER TABLE `{$installer->getTable('customer_group')}`  MODIFY `customer_group_code` varchar(127) default ''");

if (!$installer->tableExists($installer->getTable('egovsbase/mail_attachment'))
		&& $installer->tableExists($installer->getTable('core/email_queue')))
{
	$table = $installer->getConnection()
	->newTable($installer->getTable('egovsbase/mail_attachment'))
	->addColumn('att_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
			'identity'  => true,
			'unsigned'  => true,
			'nullable'  => false,
			'primary'   => true,
	), 'Entity ID')
	->addColumn('message_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Message Id')
	->addForeignKey('fk_relation_store','message_id', $installer->getTable('core/email_queue'), 'message_id',
			Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)

			//2^21 => 2MB
	->addColumn('body', Varien_Db_Ddl_Table::TYPE_TEXT, 2097152, array('default'=>''), 'Body')
	->addColumn('mime_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array('default'=>''), 'MimeType')
	->addColumn('disposition', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array('default'=>''), 'Disposition')
	->addColumn('encoding', Varien_Db_Ddl_Table::TYPE_VARCHAR, 128, array('default'=>''), 'Encoding')
	->addColumn('filename', Varien_Db_Ddl_Table::TYPE_VARCHAR, 1024, array('default'=>''), 'Original FileName')
	;
	$installer->getConnection()->createTable($table);
}

$installer->endSetup();