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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Egovs
 * @package    Egovs_Search
 * @copyright  Copyright (c)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Egovs_Search_Model_Mysql4_Advanced_Collection extends Mage_CatalogSearch_Model_Mysql4_Advanced_Collection
{

    private $_qtyApplied = false;

    private $_categoryApplied = false;
    
    protected function _addQtyOrdered() {
        $year = Mage::app()->getLocale()->date(null, Zend_Date::YEAR);
        $year = $year->get(Zend_Date::YEAR);
        $period = "best.period >= '$year-01-01'";
        $this->getSelect()
            ->joinLeft( array('best' => $this->getTable('sales/bestsellers_aggregated_yearly')), "best.product_id=e.entity_id and best.store_id = {$this->getStoreId()} and $period", array('ordered_qty' => 'sum(qty_ordered)'))
        ;
        
        //die( $this->getSelect()->__toString());
        return $this;
    }

    public function setOrder($attribute, $dir = 'desc')
    {
        $dir = $dir == 'desc' ? 'desc' : 'asc';
        if ($attribute == 'relevance') {
            $this->getSelect()->order("relevance {$dir}");
        } else if ($attribute == 'ordered_qty') {
            $this->_addQtyOrdered();
            $this->getSelect()->group('e.entity_id')
                ->order("ordered_qty {$dir}");
        } else {
            parent::setOrder($attribute, $dir);
        }
        // die( $this->getSelect()->__toString());
        return $this;
    }

    public function addAvailProductFilter($availStatus)
    {
        // die('addAvailProductFilter');
        $this->_productLimitationFilters['avial'] = $availStatus;
        $this->_applyProductAvail();
        return $this;
    }

    protected function _applyProductAvail()
    {
        parent::_applyProductLimitations();
        if (isset($this->_productLimitationFilters['avial'])) {
            if (($this->_qtyApplied === false) && ($this->_productLimitationFilters['avial'] == 'instock')) {
                $select = $this->getSelect();
                $select->distinct();
                // $select->where('e.entity_id in (SELECT product FROM cataloginventory_stock_item_parent_merged group by product)');
                $select->join(array(
                    'stock' => 'cataloginventory_stock_status'
                ), 'e.entity_id = stock.product_id', array());
                $select->where('stock.stock_status = 1');
            }
            $this->_qtyApplied = true;
        }
        // die( $this->getSelect()->__toString());
        return $this;
    }

    public function addCategoryByIdFilter($cats)
    {
        // die('addCategoryByIdFilter');
        if (count($cats) < 1)
            return $this;
        $this->_productLimitationFilters['category'] = 'test'; // $cats;
        $this->_applyCategory($cats);
        return $this;
    }

    protected function _applyCategory($cats)
    {
        parent::_applyProductLimitations();
        $cats = array_filter($cats);
        foreach ($cats as $k => $v) {
            $cats[$k] = intval($v);
        }
        if (isset($this->_productLimitationFilters['category']) && (count($cats) > 0)) {
            $crit = '(' . implode(',', $cats) . ')';
            
            if (($this->_categoryApplied === false)) {
                $this->getSelect()
                    ->
                // $select->where('e.entity_id in (SELECT product FROM cataloginventory_stock_item_parent_merged group by product)');
                join(array(
                    'cat' => 'catalog_category_product'
                ), 'e.entity_id = cat.product_id', array())
                    ->where('cat.category_id in ? ', new Zend_Db_Expr($crit));
            }
            $this->_categoryApplied = true;
        }
        
        return $this;
    }

    public function getSelectCountSql()
    {
        $this->_applyProductLimitations();
        $countSelect = clone $this->getSelect();
        
        $helper = Mage::helper('netzarbeiter_groupscatalog2');
        if ($helper) {
            Mage::getResourceSingleton('netzarbeiter_groupscatalog2/filter')->addGroupsCatalogProductFilterToSelect($countSelect, $this->getCustomerGroupId(), $this->getStoreId());
        }
        
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $countSelect->reset(Zend_Db_Select::COLUMNS);
        
        $countSelect->from('', 'COUNT(*)');
        // die( $countSelect->__toString());
        return $countSelect;
    }

    public function getCustomerGroupId()
    {
        return Mage::getSingleton('customer/session')->getCustomerGroupId();
    }
}