<?php
/**
 * SQL installer
 * 
 * @category	B3it
 * @package		B3it_Admin
 * @author		René Mütterlein <r.muetterlein@b3-it.de>
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer   = $this;
$connection  = $installer->getConnection();
$adminTable = $installer->getTable('admin/user');

$installer->startSetup();

if (!$connection->tableColumnExists($adminTable, 'failed_last_login_date')) {

    $connection->addColumn(
        $adminTable,
        'failed_last_login_date',
        array(
            'type'     => Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
            'nullable' => true,
            'comment'  => 'Timestamp of incorrect logins'
        )
    );

}

if (!$connection->tableColumnExists($adminTable, 'failed_logins_count')) {

    $connection->addColumn(
        $adminTable,
        'failed_logins_count',
        array(
            'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
            'nullable' => false,
            'length'   => 5,
            'default'  => 0,
            'comment'  => 'Number of incorrect logins'
        )
    );

}

if (!$connection->tableColumnExists($adminTable, 'otp_token_id')) {

	$connection->addColumn(
			$adminTable,
			'otp_token_id',
			'varchar(255)'
	);
}

if (!$connection->tableColumnExists($adminTable, 'use_otp_token')) {

	$connection->addColumn(
			$adminTable,
			'use_otp_token',
			array(
					'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
					'unsigned' => true,
					'nullable' => false,
					'default'  => 0,
					'comment'  => 'Use OTP Token'
			)
	);
}

$installer->endSetup();
