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
 * @var Bkg_VirtualGeo_Model_Resource_Setup $installer
 */
$installer = $this;

$installer->startSetup();

$tableName = 'virtualgeo_bundle_option';
if (!$installer->tableExists($tableName)) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable($tableName))
        ->addColumn('option_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Option entity ID')
        ->addColumn('parent_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Parent ID')
        ->addColumn('required', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Is required')
        ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Position')
        ->addColumn('type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => true,
            'default'   => 'radio',
        ), 'HTML input type')
        ->addColumn('resource', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => true,
            'default'   => null,
        ), 'Resource type')
        ->addColumn('ref_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => true,
            'default'   => null,
        ), 'Reference ID')
        ->addColumn('title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => true,
            'default'   => null,
        ), 'Title')
        ->addIndex($installer->getIdxName($tableName, 'parent_id'), array('parent_id'))
        ->addIndex($installer->getIdxName($tableName, array('ref_id', 'resource')), array('ref_id', 'resource'))
    ;
    $installer->getConnection()->createTable($table);
}

$tableName = 'virtualgeo_bundle_selection';
if (!$installer->tableExists($tableName)) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable($tableName))
        ->addColumn('selection_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Selection entity ID')
        ->addColumn('option_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Option ID')
        ->addColumn('parent_product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Parent product ID')
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Product ID')
        ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Position')
        ->addColumn('is_default', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Is default')
        ->addColumn('selection_price_type', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Selection Price Type')
        ->addColumn('selection_price_value', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
            'nullable'  => false,
            'default'   => 0.0000,
        ), 'Selection Price Value')
        ->addColumn('selection_qty', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
            'nullable'  => true,
            'default'   => null,
        ), 'Selection Qty')
        ->addColumn('selection_can_change_qty', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'nullable'  => false,
            'default'   => 0,
        ), 'Selection Can Change Qty')
        ->addColumn('is_visible_only_in_admin', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Only visible in admin')
        ->addColumn('resource', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => true,
            'default'   => null,
        ), 'Resource type')
        ->addColumn('ref_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Reference ID')
        ->addIndex($installer->getIdxName($tableName, 'option_id'), array('option_id'))
        ->addIndex($installer->getIdxName($tableName, 'product_id'), array('product_id'))
        ->addIndex($installer->getIdxName($tableName, array('ref_id', 'resource')), array('ref_id', 'resource'))
        ->addForeignKey($installer->getFkName($tableName, 'option_id', 'virtualgeo/bundle_option', 'option_id'),
            'option_id', $installer->getTable('virtualgeo/bundle_option'), 'option_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey($installer->getFkName($tableName, 'product_id', 'catalog/product', 'entity_id'),
            'product_id', $installer->getTable('catalog/product'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ;
    $installer->getConnection()->createTable($table);
}

$tableName = 'virtualgeo_components_option_type_value';
if (!$installer->tableExists($tableName)) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable($tableName))
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'ID')
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Component ID')
        ->addColumn('component_type', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Component Type')
        ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Product ID')
        ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Store ID')
        ->addColumn('pos', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Position')
        ->addColumn('is_default', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Is default')
        ->addColumn('is_visible_only_in_admin', Varien_Db_Ddl_Table::TYPE_SMALLINT, 5, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Only visible in admin')
        ->addIndex($installer->getIdxName($tableName, 'entity_id'), array('entity_id'))
        ->addIndex($installer->getIdxName($tableName, 'component_type'), array('component_type'))
        ->addIndex($installer->getIdxName($tableName, 'product_id'), array('product_id'))
        ->addIndex($installer->getIdxName($tableName, 'store_id'), array('store_id'))
        ->addForeignKey($installer->getFkName($tableName, 'product_id', 'catalog/product', 'entity_id'),
            'product_id', $installer->getTable('catalog/product'), 'entity_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey($installer->getFkName($tableName, 'store_id', 'core/store', 'store_id'),
            'store_id', $installer->getTable('core/store'), 'store_id',
            Varien_Db_Ddl_Table::ACTION_CASCADE)
    ;
    $installer->getConnection()->createTable($table);
}

$tableName = 'virtualgeo_components_content_option_value';
if (!$installer->tableExists($tableName)) {
    $table = $installer->getConnection()
        ->newTable($installer->getTable($tableName))
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'ID')
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => false,
        ), 'Option Type Value ID')
        ->addColumn('parent_node_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => true,
            'default'   => null,
        ), 'Product ID')
        ->addColumn('readonly', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Is Readonly')
        ->addColumn('is_checked', Varien_Db_Ddl_Table::TYPE_SMALLINT, 6, array(
            'unsigned'  => true,
            'nullable'  => false,
            'default'   => 0,
        ), 'Is Checked')
        ->addIndex($installer->getIdxName($tableName, 'entity_id'), array('entity_id'))
        ->addIndex($installer->getIdxName($tableName, 'parent_node_id'), array('parent_node_id'))
        ->addForeignKey($installer->getFkName($tableName, 'parent_node_id', 'virtualgeo/components_content_option_value', 'id'),
            'parent_node_id', $installer->getTable('virtualgeo/components_content_option_value'), 'id',
            Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
        ->addForeignKey($installer->getFkName($tableName, 'entity_id', 'virtualgeo/product_option_value', 'id'),
            'entity_id', $installer->getTable('virtualgeo/product_option_value'), 'id',
            Varien_Db_Ddl_Table::ACTION_CASCADE)
    ;
    $installer->getConnection()->createTable($table);
}

$installer->endSetup();