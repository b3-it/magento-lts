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

$tableName = 'paymentbase/incoming_payment';
if (!$installer->tableExists($tableName)) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable($tableName))
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Entity ID')
        ->addColumn('order_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Bestell ID')
        ->addColumn('paid', Varien_Db_Ddl_Table::TYPE_DECIMAL,'12,4', array())
        ->addColumn('total_paid', Varien_Db_Ddl_Table::TYPE_DECIMAL,'12,4', array())
        ->addColumn('base_paid', Varien_Db_Ddl_Table::TYPE_DECIMAL,'12,4', array())
        ->addColumn('base_total_paid', Varien_Db_Ddl_Table::TYPE_DECIMAL,'12,4', array())
        ->addColumn(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CAPTURE_DATE, Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'epayBL Kundennummer')
        ->addIndex($installer->getIdxName($tableName, 'order_id'), array('order_id'))
        ->addForeignKey($installer->getFkName($tableName, 'order_id', 'sales/order', 'entity_id'),
            'order_id', $installer->getTable('sales/order'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ;
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();