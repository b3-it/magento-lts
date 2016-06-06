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
class Egovs_EventBundle_Model_Resource_Indexer_Stock extends Mage_Bundle_Model_Resource_Indexer_Stock
{
   

    
    /**
     * Prepare stock status per Bundle options, website and stock
     *
     * @param int|array $entityIds
     * @param bool $usePrimaryTable use primary or temporary index table
     * @return Mage_Bundle_Model_Resource_Indexer_Stock
     */
    protected function _prepareBundleOptionStockData($entityIds = null, $usePrimaryTable = false)
    {
        $this->_cleanBundleOptionStockData();
        $idxTable = $usePrimaryTable ? $this->getMainTable() : $this->getIdxTable();
        $adapter  = $this->_getWriteAdapter();
        $select   = $adapter->select()
            ->from(array('bo' => $this->getTable('bundle/option')), array('parent_id'));
        $this->_addWebsiteJoinToSelect($select, false);
        $status = new Zend_Db_Expr('MAX(' .
                $adapter->getCheckSql('e.required_options = 0', 'i.stock_status', '0') . ')');
        $select->columns('website_id', 'cw')
            ->join(
                array('cis' => $this->getTable('cataloginventory/stock')),
                '',
                array('stock_id')
            )
            ->joinLeft(
                array('bs' => $this->getTable('bundle/selection')),
                'bs.option_id = bo.option_id',
                array()
            )
            ->joinLeft(
                array('i' => $idxTable),
                'i.product_id = bs.product_id AND i.website_id = cw.website_id AND i.stock_id = cis.stock_id',
                array()
            )
            ->joinLeft(
                array('e' => $this->getTable('catalog/product')),
                'e.entity_id = bs.product_id',
                array()
            )
            ->where('cw.website_id != 0')
            ->group(array('bo.parent_id', 'cw.website_id', 'cis.stock_id', 'bo.option_id'))
            ->columns(array(
                'option_id' => 'bo.option_id',
                'status'    => $status
            ));

        if (!is_null($entityIds)) {
            $select->where('bo.parent_id IN(?)', $entityIds);
        }

        // clone select for bundle product without required bundle options
        $selectNonRequired = clone $select;

        $select->where('bo.required = ?', 1);
        $selectNonRequired->where('bo.required != ?', 1)
            ->having($status . ' = 1');
        $query = $select->insertFromSelect($this->_getBundleOptionTable());
        $adapter->query($query);

        $query = $selectNonRequired->insertFromSelect($this->_getBundleOptionTable());
        $adapter->query($query);

        return $this;
    }


}
