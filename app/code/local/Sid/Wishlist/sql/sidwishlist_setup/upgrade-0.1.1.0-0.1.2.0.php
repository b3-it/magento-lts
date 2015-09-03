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

$installer->getConnection()->addColumn(
		$installer->getTable('sidwishlist/quote'),
		'grand_total',
		array(
				'type'    => Varien_Db_Ddl_Table::TYPE_DECIMAL,
				'precision' => 12,
				'scale'   => 4,
				'comment' => 'Grand Total',
				'default' => 0.0
		)
);
$installer->getConnection()->addColumn(
		$installer->getTable('sidwishlist/quote'),
		'base_grand_total',
		array(
				'type'    => Varien_Db_Ddl_Table::TYPE_DECIMAL,
				'precision' => 12,
				'scale'   => 4,
				'comment' => 'Base Grand Total',
				'default' => 0.0
		)
);
$installer->getConnection()->addColumn(
		$installer->getTable('sidwishlist/quote'),
		'is_virtual',
		array(
				'type'    => Varien_Db_Ddl_Table::TYPE_BOOLEAN,
				'comment' => 'Is Virtual',
				'default' => 0
		)
);