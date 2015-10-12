<?php
/**
 * Model Resource-Setup
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/* @var $installer Sid_Wishlist_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

/**
 * Create table 'sidwishlist/quote'
 */
$installer->getConnection()
	->dropTable($installer->getTable('sidwishlist/quote'));
$table = $installer->getConnection()->newTable($installer->getTable('sidwishlist/quote'))
    ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Entity Id')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Store Id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        ), 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        ), 'Updated At')
    ->addColumn('converted_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => true,
        ), 'Converted At')
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'default'   => '1',
        ), 'Is Active')
    ->addColumn('is_default', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
    	'unsigned'  => true,
    	'default'   => '0',
        ), 'Is Default')
    ->addColumn('quote_entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'default'   => '0',
        ), 'Magento Sales Quote Entity Id')
    ->addColumn('items_count', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'default'   => '0',
        ), 'Items Count')
    ->addColumn('items_qty', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'default'   => '0.0000',
        ), 'Items Qty')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'default'   => '0',
        ), 'Customer Id (Owner)')
    ->addColumn('customer_group_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'default'   => '0',
        ), 'Customer Group Id (Owner)')
    ->addColumn('customer_email', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Customer Email (Owner)')
    ->addColumn('customer_prefix', Varien_Db_Ddl_Table::TYPE_TEXT, 40, array(
        ), 'Customer Prefix (Owner)')
    ->addColumn('customer_firstname', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Customer Firstname (Owner)')
    ->addColumn('customer_middlename', Varien_Db_Ddl_Table::TYPE_TEXT, 40, array(
        ), 'Customer Middlename (Owner)')
    ->addColumn('customer_lastname', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Customer Lastname (Owner)')
    ->addColumn('customer_suffix', Varien_Db_Ddl_Table::TYPE_TEXT, 40, array(
        ), 'Customer Suffix (Owner)')
    ->addColumn('customer_note', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Customer Note (Owner)')
    ->addColumn('customer_note_notify', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        'default'   => '1',
        ), 'Customer Note Notify')
    ->addColumn('is_changed', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Is Changed')
    ->addColumn('customer_acls', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        ), 'Customer Acls')
    ->addColumn('sharing_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, 32, array(
        ), 'Customer Acls')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Quote Name')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        ), 'Description')
    ->addIndex($installer->getIdxName('sidwishlist/quote', array('customer_id', 'store_id', 'is_active')),
        array('customer_id', 'store_id', 'is_active'))
    ->addIndex($installer->getIdxName('sidwishlist/quote', array('store_id')),
        array('store_id'))
    ->addForeignKey($installer->getFkName('sidwishlist/quote', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sidwishlist/quote', 'quote_entity_id', 'sales/quote', 'entity_id'),
    	'quote_entity_id', $installer->getTable('sales/quote'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Sid Wishlist Flat Quote');
$installer->getConnection()->createTable($table);


/**
 * Create table 'sidwishlist/quote_item'
 */
$installer->getConnection()
	->dropTable($installer->getTable('sidwishlist/quote_item'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('sidwishlist/quote_item'))
    ->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Item Id')
    ->addColumn('quote_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Sid Wishlist Quote Id')
    ->addColumn('quote_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        'default'   => '0',
        ), 'Magento Sales Quote Item Id')
    ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        ), 'Created At')
    ->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        'nullable'  => false,
        ), 'Updated At')
    ->addColumn('converted_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        	'nullable'  => false,
        ), 'Converted At')
    ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Customer Id (Creator)')
    ->addColumn('store_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        ), 'Store Id')
    ->addColumn('status_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Status Id')
    ->addColumn('parent_item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        ), 'Parent Item Id')
    ->addColumn('frame_contract_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        	'unsigned'  => true,
        ), 'Frame Contract ID')
    ->addColumn('frame_contract_title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        ), 'Frame Contract Title')
    ->addColumn('frame_contract_number', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        ), 'Frame Contract Number')
    ->addColumn('is_virtual', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'unsigned'  => true,
        ), 'Is Virtual')
    ->addColumn('description', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        ), 'Description')
    ->addColumn('applied_rule_ids', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        ), 'Applied Rule Ids')
    ->addColumn('additional_data', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        ), 'Additional Data')
    ->addColumn('is_qty_decimal', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        	'unsigned'  => true,
        ), 'Is Qty Decimal')
    ->addColumn('qty_requested', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
       		'nullable'  => false,
        	'default'   => '0.0000',
        ), 'Qty Requested')
    ->addColumn('qty_granted', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        	'nullable'  => false,
        	'default'   => '0.0000',
        ), 'Qty Granted')    
    ->addColumn('redirect_url', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        ), 'Redirect Url')
    ->addIndex($installer->getIdxName('sidwishlist/quote_item', array('parent_item_id')),
        array('parent_item_id'))
    ->addIndex($installer->getIdxName('sidwishlist/quote_item', array('quote_id')),
        array('quote_id'))
    ->addIndex($installer->getIdxName('sidwishlist/quote_item', array('quote_item_id')),
        array('quote_item_id'))
    ->addIndex($installer->getIdxName('sidwishlist/quote_item', array('store_id')),
        array('store_id'))
    ->addForeignKey($installer->getFkName('sidwishlist/quote_item', 'parent_item_id', 'sidwishlist/quote_item', 'item_id'),
        'parent_item_id', $installer->getTable('sidwishlist/quote_item'), 'item_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    /* ->addForeignKey($installer->getFkName('sidwishlist/quote_item', 'customer_id', 'customer/customer', 'entity_id'),
        'customer_id', $installer->getTable('customer/customer'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE) */
    ->addForeignKey($installer->getFkName('sidwishlist/quote_item', 'quote_id', 'sidwishlist/quote', 'entity_id'),
        'quote_id', $installer->getTable('sidwishlist/quote'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sidwishlist/quote_item', 'quote_item_id', 'sales/quote_item', 'item_id'),
        'quote_item_id', $installer->getTable('sales/quote_item'), 'item_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($installer->getFkName('sidwishlist/quote_item', 'store_id', 'core/store', 'store_id'),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_SET_NULL, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Sid Wishlist Flat Quote Item');
$installer->getConnection()->createTable($table);

/**
 * Create table 'sidwishlist/quote_item_option'
 */
$installer->getConnection()
	->dropTable($installer->getTable('sidwishlist/quote_item_option'));
$table = $installer->getConnection()
    ->newTable($installer->getTable('sidwishlist/quote_item_option'))
    ->addColumn('option_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Option Id')
    ->addColumn('item_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Item Id')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'  => true,
        'nullable'  => false,
        ), 'Product Id')
    ->addColumn('code', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Code')
    ->addColumn('value', Varien_Db_Ddl_Table::TYPE_TEXT, '64k', array(
        ), 'Value')
    ->addIndex($installer->getIdxName('sidwishlist/quote_item_option', array('item_id')),
        array('item_id'))
    ->addForeignKey($installer->getFkName('sidwishlist/quote_item_option', 'item_id', 'sidwishlist/quote_item', 'item_id'),
        'item_id', $installer->getTable('sidwishlist/quote_item'), 'item_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('Sid Wishlist Flat Quote Item Option');
$installer->getConnection()->createTable($table);


$installer->endSetup();
