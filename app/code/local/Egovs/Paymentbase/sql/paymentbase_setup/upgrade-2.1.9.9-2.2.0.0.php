<?php
/**
 * Eigener Reiter für ePayBL
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2018 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 * @var Egovs_Paymentbase_Model_Resource_Setup $installer
 */
$installer = $this;

$installer->startSetup();

$entityTypeId = 'order_payment';
$attributeId = Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_STATUS;

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {
    $installer->getConnection()->addColumn(
        $installer->getTable('sales/order_payment'),
        $attributeId,
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
            'unsigned'  => true,
            'nullable' => true,
            'default' => null,
            'comment' => 'APR Status'
        )
    );
}

$tableName = 'paymentbase/incoming_payment';
$column = 'message';
if ($installer->tableExists($tableName) && !$installer->getConnection()->tableColumnExists($installer->getTable($tableName), $column)) {
    $installer->getConnection()->addColumn(
        $installer->getTable($tableName),
        $column,
        'varchar(255) DEFAULT NULL'
    );
}

$installer->endSetup();