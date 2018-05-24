<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 11:07
 */

class Bkg_VirtualGeo_Model_Resource_Bundle_Selection_Collection extends Mage_Bundle_Model_Resource_Selection_Collection
{
    /**
     * Init model and resource model
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_selectionTable = $this->getTable('virtualgeo/bundle_selection');
    }

    /**
     * Initialize collection select
     *
     */
    protected function _initSelect()
    {
        Mage_Catalog_Model_Resource_Product_Collection::_initSelect();
        $this->getSelect()->joinRight(array('selection' => $this->_selectionTable),
            'selection.product_id = e.entity_id',
            array('*')
        );
    }

    public function addFieldToFilter($attribute, $condition = null) {
        if (is_string($attribute) && stripos($attribute, 'selection') === 0) {
            $field = explode('.', $attribute);

            if (count($field) == 2 && $field[0] == 'selection') {
                $this->getSelect()->where("{$attribute} = ?", $condition);

                return $this;
            }
        } else {
            return parent::addFieldToFilter($attribute, $condition); // TODO: Change the autogenerated stub
        }
    }

    protected function _productLimitationJoinWebsite() {
        $joinWebsite = false;
        $filters     = $this->_productLimitationFilters;
        $conditions  = array('(product_website.product_id = e.entity_id or (product_website.product_id = selection.parent_product_id))');

        if (isset($filters['website_ids'])) {
            $joinWebsite = true;
            if (count($filters['website_ids']) > 1) {
                $this->getSelect()->distinct(true);
            }
            $conditions[] = $this->getConnection()
                ->quoteInto('product_website.website_id IN(?)', $filters['website_ids']);
        } elseif (isset($filters['store_id'])
            && (!isset($filters['visibility']) && !isset($filters['category_id']))
            && !$this->isEnabledFlat()
        ) {
            $joinWebsite = true;
            $websiteId = Mage::app()->getStore($filters['store_id'])->getWebsiteId();
            $conditions[] = $this->getConnection()
                ->quoteInto('product_website.website_id = ?', $websiteId);
        }

        $fromPart = $this->getSelect()->getPart(Zend_Db_Select::FROM);
        if (isset($fromPart['product_website'])) {
            if (!$joinWebsite) {
                unset($fromPart['product_website']);
            } else {
                $fromPart['product_website']['joinCondition'] = join(' AND ', $conditions);
            }
            $this->getSelect()->setPart(Zend_Db_Select::FROM, $fromPart);
        } elseif ($joinWebsite) {
            $this->getSelect()->join(
                array('product_website' => $this->getTable('catalog/product_website')),
                join(' AND ', $conditions),
                array()
            );
        }

        return $this;
    }

    protected function _beforeLoad() {
        if (!Mage::helper('core')->isModuleEnabled('Netzarbeiter_GroupsCatalog2')) {
            parent::_beforeLoad();
        }

        /* @var $helper Netzarbeiter_GroupsCatalog2_Helper_Data */
        $helper = Mage::helper('netzarbeiter_groupscatalog2');

        $table = $this->getTable($helper->getIndexTableByEntityType($this->getEntity()->getEntityType()));
        $groupId = $helper->getCustomerGroupId();
        $storeId = $this->getStoreId();
        $select = $this->getSelect();

        $select->joinInner(
            $table,
            "({$table}.catalog_entity_id=".self::MAIN_TABLE_ALIAS.".{$this->getEntity()->getIdFieldName()} OR {$table}.catalog_entity_id=selection.parent_product_id) AND " .
            $this->getSelect()->getAdapter()->quoteInto("{$table}.group_id=? AND ", $groupId) .
            $this->getSelect()->getAdapter()->quoteInto("{$table}.store_id=?", $storeId),
            array()
        );
        return parent::_beforeLoad(); // TODO: Change the autogenerated stub
    }
}