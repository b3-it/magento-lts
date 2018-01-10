<?php
/**
 * SQL installer
 *
 * @category	B3it
 * @package		B3it_Admin
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2018 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer   = $this;
$connection  = $installer->getConnection();
$adminTable = $installer->getTable('admin/user');

$installer->startSetup();

if (!$connection->tableColumnExists($adminTable, 'show_login_info')) {

    $connection->addColumn(
        $adminTable,
        'show_login_info',
        array(
            'type'     => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
            'nullable' => true,
            'comment'  => 'Show login information after logon'
        )
    );

}

$installer->endSetup();