<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Bundle
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Bundle Stock Status Indexer Resource Model
 *
 * @category    Mage
 * @package     Mage_Bundle
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Bkg_VirtualGeo_Model_Resource_Indexer_Stock extends Mage_Bundle_Model_Resource_Indexer_Stock
{
   
	/**
	 * Get the select object for get stock status by product ids
	 *
	 * @param int|array $entityIds
	 * @param bool $usePrimaryTable use primary or temporary index table
	 * @return Varien_Db_Select
	 */
	protected function _getStockStatusSelect($entityIds = null, $usePrimaryTable = false)
	{
		
		$storageExpr = new Zend_Db_Expr("(SELECT t1.*, t2.product_id as t2_p_id FROM {$this->getTable('cataloginventory/stock_status')} as t1 JOIN {$this->getTable('virtualgeo/components_storage_product')} as t2 ON t1.product_id = t2.transport_product_id )");
		
		$adapter = $this->_getWriteAdapter();
		$select  = $adapter->select()
		->from(array('e' => $this->getTable('catalog/product')), array('entity_id'));
		$this->_addWebsiteJoinToSelect($select, true);
		$this->_addProductWebsiteJoinToSelect($select, 'cw.website_id', 'e.entity_id');
		$select->columns('cw.website_id')
		->join(
				array('cis' => $this->getTable('cataloginventory/stock')),
				'',
				array('stock_id')
				)
				->joinLeft(
						array('cisi' => $this->getTable('cataloginventory/stock_item')),
						'cisi.stock_id = cis.stock_id AND cisi.product_id = e.entity_id',
						array()
						)
						->joinLeft(
								array('o' => $storageExpr),
								'o.t2_p_id = e.entity_id AND o.website_id = cw.website_id AND o.stock_id = cis.stock_id',
								array()
								)
								->columns(array('qty' => new Zend_Db_Expr('0')))
								->where('cw.website_id != 0')
								->where('e.type_id = ?', $this->getTypeId())
								->group(array('e.entity_id', 'cw.website_id', 'cis.stock_id'));
	
								// add limitation of status
								$condition = $adapter->quoteInto('=?', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
								$this->_addAttributeToSelect($select, 'status', 'e.entity_id', 'cs.store_id', $condition);
	
								if ($this->_isManageStock()) {
									$statusExpr = $adapter->getCheckSql(
											'cisi.use_config_manage_stock = 0 AND cisi.manage_stock = 0',
											'1',
											'cisi.is_in_stock'
											);
								} else {
									$statusExpr = $adapter->getCheckSql(
											'cisi.use_config_manage_stock = 0 AND cisi.manage_stock = 1',
											'cisi.is_in_stock',
											'1'
											);
								}
	
								$select->columns(array('status' => $adapter->getLeastSql(array(
										new Zend_Db_Expr('MIN(' . $adapter->getCheckSql('o.stock_status IS NOT NULL','o.stock_status', '0') .')'),
										new Zend_Db_Expr('MIN(' . $statusExpr . ')'),
								))));
	
								if (!is_null($entityIds)) {
									$select->where('e.entity_id IN(?)', $entityIds);
								}
		//die($select->__toString());
								return $select;
	}

    
    
   


}
