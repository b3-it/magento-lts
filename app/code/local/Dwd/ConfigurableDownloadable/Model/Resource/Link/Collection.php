<?php
/**
 * Configurable Downloadable Products resource Collection
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Resource_Link_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Init resource model
     * 
     * @return void
     */
    protected function _construct() {
        $this->_init('configdownloadable/link');
    }

    /**
     * Method for product filter
     *
     * @param Mage_Catalog_Model_Product|array|integer|null $product Product
     * 
     * @return Dwd_ConfigurableDownloadable_Model_Resource_Link_Collection
     */
    public function addProductToFilter($product) {
        if (empty($product)) {
            $this->addFieldToFilter('product_id', '');
        } elseif ($product instanceof Mage_Catalog_Model_Product) {
            $this->addFieldToFilter('product_id', $product->getId());
        } else {
            $this->addFieldToFilter('product_id', array('in' => $product));
        }

        return $this;
    }

    /**
     * Retrieve title for for current store
     *
     * @param integer $storeId Store ID
     * 
     * @return Dwd_ConfigurableDownloadable_Model_Resource_Link_Collection
     */
    public function addTitleToResult($storeId = 0) {
        $ifNullDefaultTitle = $this->getConnection()
            ->getIfNullSql('st.title', 'd.title');
        $this->getSelect()
            ->joinLeft(array('d' => $this->getTable('configdownloadable/link_title')),
                'd.link_id=main_table.link_id AND d.store_id = 0',
                array('default_title' => 'title'))
            ->joinLeft(array('st' => $this->getTable('configdownloadable/link_title')),
                'st.link_id=main_table.link_id AND st.store_id = ' . intval($storeId),
                array('store_title' => 'title','title' => $ifNullDefaultTitle))
            ->order('main_table.sort_order ASC')
            ->order('title ASC');

        return $this;
    }

    /**
     * Retrieve price for for current website
     *
     * @param integer $websiteId Website ID
     * 
     * @return Dwd_ConfigurableDownloadable_Model_Resource_Link_Collection
     */
    public function addPriceToResult($websiteId) {
        $ifNullDefaultPrice = $this->getConnection()
            ->getIfNullSql('stp.price', 'dp.price');
        $this->getSelect()
            ->joinLeft(array('dp' => $this->getTable('configdownloadable/link_price')),
                'dp.link_id=main_table.link_id AND dp.website_id = 0',
                array('default_price' => 'price'))
            ->joinLeft(array('stp' => $this->getTable('configdownloadable/link_price')),
                'stp.link_id=main_table.link_id AND stp.website_id = ' . (int)$websiteId,
                array('website_price' => 'price','price' => $ifNullDefaultPrice));

        return $this;
    }
}
