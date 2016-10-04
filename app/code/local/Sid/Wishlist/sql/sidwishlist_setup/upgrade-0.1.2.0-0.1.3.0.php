<?php
/**
 * Model Resource-Setup
 *
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 *  @var $installer Sid_Wishlist_Model_Resource_Setup
 */
$installer = $this;

$installer->getConnection()->addColumn(
		$installer->getTable('sales/quote_item'),
		'sidwishlist_item_id',
		array(
				'type'    => Varien_Db_Ddl_Table::TYPE_INTEGER,
				'nullable'  => true,
				'comment' => 'Sidwishlist Item ID',
				'default' => null
		)
);

$installer->getConnection()->addColumn(
		$installer->getTable('sales/order_item'),
		'sidwishlist_item_id',
		array(
				'type'    => Varien_Db_Ddl_Table::TYPE_INTEGER,
				'nullable'  => true,
				'comment' => 'Sidwishlist Item ID',
				'default' => null
		)
);

$installer->getConnection()->addColumn(
		$installer->getTable('sidwishlist/quote_item'),
		'qty_ordered',
		array(
				'type'    => Varien_Db_Ddl_Table::TYPE_DECIMAL,
				'precision' => 12,
				'scale'   => 4,
				'comment' => 'Qty Ordered',
				'default' => 0.0
		)
);