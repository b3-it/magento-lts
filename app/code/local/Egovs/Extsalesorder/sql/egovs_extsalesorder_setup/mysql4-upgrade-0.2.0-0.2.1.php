<?php

$installer = $this;

$installer->startSetup();

/*
 * Falls user_defined => true benutzt wird, muss ein Attributset bzw. eine Gruppe angegeben werden.
 * Falls user_defined => false so wird es in alle Attributsets integriert (Gruppe: General)
 */

/* @var $installer Mage_Sales_Model_Resource_Setup */
if (version_compare(Mage::getVersion(), '1.4.0', '<')) {
	Mage::log(sprintf('extsalesorder::SQL Setup supports onnly Magento 1.4.1 and greater!'), Zend_Log::ERR);
}
//Add extra information
//################################################################################################################################
$tableName = 'sales/order_grid';
$fieldName = 'payment_method';
// Add column to grid table
if (!$installer->getConnection()->tableColumnExists($installer->getTable($tableName), $fieldName)) {
	$installer->getConnection()->addColumn(
			$installer->getTable($tableName),
			$fieldName,
			"varchar(255) not null default ''"
	);
}
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
$indizes = $installer->getConnection()->getIndexList($installer->getTable($tableName));
if (!array_key_exists(strtoupper($fieldName), $indizes)) {
	$installer->getConnection()->addKey(
			$installer->getTable($tableName),
			$fieldName,
			$fieldName
	);
}
// Now you need to fullfill existing rows with data from source table
$select = $installer->getConnection()->select();
$select->join(
		array('payment'=>$installer->getTable('sales/order_payment')),
		'payment.parent_id = order_grid.entity_id',
		array($fieldName => 'method')
);
$installer->getConnection()->query(
		$select->crossUpdateFromSelect(
				array('order_grid' => $installer->getTable($tableName))
		)
);

$fieldName = 'billing_company';
// Add column to grid table
if (!$installer->getConnection()->tableColumnExists($installer->getTable($tableName), $fieldName)) {
	$installer->getConnection()->addColumn(
			$installer->getTable($tableName),
			$fieldName,
			"varchar(255) not null default ''"
	);
}
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
if (!array_key_exists(strtoupper($fieldName), $indizes)) {
	$installer->getConnection()->addKey(
			$installer->getTable($tableName),
			$fieldName,
			$fieldName
	);
}
// Now you need to fullfill existing rows with data from source table
$expr = new Zend_Db_Expr("CONCAT_WS(',<br>\n', `company`, `company2`, `company3`)");
$select = $installer->getConnection()->select();
$select->join(
		array('address'=>$installer->getTable('sales/order_address')),
		$this->getConnection()->quoteInto(
	        'address.parent_id = order_grid.entity_id AND address.address_type = ?',
	        Mage_Sales_Model_Quote_Address::TYPE_BILLING
	    ),
		array($fieldName => $expr)
);
$installer->getConnection()->query(
		$select->crossUpdateFromSelect(
				array('order_grid' => $installer->getTable($tableName))
		)
);

$fieldName = 'billing_address';
// Add column to grid table
if (!$installer->getConnection()->tableColumnExists($installer->getTable($tableName), $fieldName)) {
	$installer->getConnection()->addColumn(
			$installer->getTable($tableName),
			$fieldName,
			"varchar(255) not null default ''"
	);
}
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
if (!array_key_exists(strtoupper($fieldName), $indizes)) {
	$installer->getConnection()->addKey(
			$installer->getTable($tableName),
			$fieldName,
			$fieldName
	);
}
// Now you need to fullfill existing rows with data from source table
$expr = new Zend_Db_Expr("CONCAT(COALESCE(`street`,''), '<br>\n', COALESCE(`city`,''), ' ', COALESCE(`postcode`,''))");
$select = $installer->getConnection()->select();
$select->join(
		array('address'=>$installer->getTable('sales/order_address')),
		$this->getConnection()->quoteInto(
				'address.parent_id = order_grid.entity_id AND address.address_type = ?',
				Mage_Sales_Model_Quote_Address::TYPE_BILLING
		),
		array($fieldName => $expr)
);
$installer->getConnection()->query(
		$select->crossUpdateFromSelect(
				array('order_grid' => $installer->getTable($tableName))
		)
);

$fieldName = 'shipping_company';
// Add column to grid table
if (!$installer->getConnection()->tableColumnExists($installer->getTable($tableName), $fieldName)) {
	$installer->getConnection()->addColumn(
			$installer->getTable($tableName),
			$fieldName,
			"varchar(255) not null default ''"
	);
}
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
if (!array_key_exists(strtoupper($fieldName), $indizes)) {
	$installer->getConnection()->addKey(
			$installer->getTable($tableName),
			$fieldName,
			$fieldName
	);
}
// Now you need to fullfill existing rows with data from source table
$expr = new Zend_Db_Expr("CONCAT_WS(',<br>\n', `company`, `company2`, `company3`)");
$select = $installer->getConnection()->select();
$select->join(
		array('address'=>$installer->getTable('sales/order_address')),
		$this->getConnection()->quoteInto(
				'address.parent_id = order_grid.entity_id AND address.address_type = ?',
				Mage_Sales_Model_Quote_Address::TYPE_SHIPPING
		),
		array($fieldName => $expr)
);
$installer->getConnection()->query(
		$select->crossUpdateFromSelect(
				array('order_grid' => $installer->getTable($tableName))
		)
);

$fieldName = 'shipping_address';
// Add column to grid table
if (!$installer->getConnection()->tableColumnExists($installer->getTable($tableName), $fieldName)) {
	$installer->getConnection()->addColumn(
			$installer->getTable($tableName),
			$fieldName,
			"varchar(255) not null default ''"
	);
}
// Add key to table for this field,
// it will improve the speed of searching & sorting by the field
if (!array_key_exists(strtoupper($fieldName), $indizes)) {
	$installer->getConnection()->addKey(
			$installer->getTable($tableName),
			$fieldName,
			$fieldName
	);
}
// Now you need to fullfill existing rows with data from source table
$expr = new Zend_Db_Expr("CONCAT(COALESCE(`street`, ''), '<br>\n', COALESCE(`city`, ''), ' ',  COALESCE(`postcode`, ''))");
$select = $installer->getConnection()->select();
$select->join(
		array('address'=>$installer->getTable('sales/order_address')),
		$this->getConnection()->quoteInto(
				'address.parent_id = order_grid.entity_id AND address.address_type = ?',
				Mage_Sales_Model_Quote_Address::TYPE_SHIPPING
		),
		array($fieldName => $expr)
);
$installer->getConnection()->query(
		$select->crossUpdateFromSelect(
				array('order_grid' => $installer->getTable($tableName))
		)
);

//End add extra information
//#############################################################################################################################

$installer->endSetup(); 