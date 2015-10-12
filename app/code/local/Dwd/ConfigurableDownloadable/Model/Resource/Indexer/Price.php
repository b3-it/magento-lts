<?php
/**
 * Configurable Downloadable Products Price resource model
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Resource_Indexer_Price extends Mage_Catalog_Model_Resource_Product_Indexer_Price_Default
{
    /**
     * Reindex temporary (price result data) for all products
     *
     * @return Dwd_ConfigurableDownloadable_Model_Resource_Indexer_Price
     */
    public function reindexAll()
    {
        $this->useIdxTable(true);
        $this->beginTransaction();
        try {
            $this->_prepareFinalPriceData();
            $this->_applyCustomOption();
            $this->_applyDownloadableLink();
            $this->_movePriceDataToIndexTable();
            $this->commit();
        } catch (Exception $e) {
            $this->rollBack();
            throw $e;
        }
        return $this;
    }

    /**
     * Reindex temporary (price result data) for defined product(s)
     *
     * @param int|array $entityIds IDs
     * 
     * @return Dwd_ConfigurableDownloadable_Model_Resource_Indexer_Price
     */
    public function reindexEntity($entityIds)
    {
        $this->_prepareFinalPriceData($entityIds);
        $this->_applyCustomOption();
        $this->_applyDownloadableLink();
        $this->_movePriceDataToIndexTable();

        return $this;
    }

    /**
     * Retrieve downloadable links price temporary index table name
     *
     * @see _prepareDefaultFinalPriceTable()
     *
     * @return string
     */
    protected function _getDownloadableLinkPriceTable()
    {
        if ($this->useIdxTable()) {
            return $this->getTable('configdownloadable/product_price_indexer_idx');
        }
        return $this->getTable('configdownloadable/product_price_indexer_tmp');
    }

    /**
     * Prepare downloadable links price temporary index table
     *
     * @return Dwd_ConfigurableDownloadable_Model_Resource_Indexer_Price
     */
    protected function _prepareDownloadableLinkPriceTable()
    {
        $this->_getWriteAdapter()->delete($this->_getDownloadableLinkPriceTable());
        return $this;
    }

    /**
     * Calculate and apply Downloadable links price to index
     *
     * @return Dwd_ConfigurableDownloadable_Model_Resource_Indexer_Price
     */
    protected function _applyDownloadableLink()
    {
        $write  = $this->_getWriteAdapter();
        $table  = $this->_getDownloadableLinkPriceTable();

        $this->_prepareDownloadableLinkPriceTable();

        $dlType = $this->_getAttribute('links_purchased_separately');

        $ifPrice = $write->getIfNullSql('dlpw.price_id', 'dlpd.price');

        $select = $write->select()
            ->from(
                array('i' => $this->_getDefaultFinalPriceTable()),
                array('entity_id', 'customer_group_id', 'website_id'))
            ->join(
                array('dl' => $dlType->getBackend()->getTable()),
                "dl.entity_id = i.entity_id AND dl.attribute_id = {$dlType->getAttributeId()}"
                    . " AND dl.store_id = 0",
                array())
            ->join(
                array('dll' => $this->getTable('configdownloadable/link')),
                'dll.product_id = i.entity_id',
                array())
            ->join(
                array('dlpd' => $this->getTable('configdownloadable/link_price')),
                'dll.link_id = dlpd.link_id AND dlpd.website_id = 0',
                array())
            ->joinLeft(
                array('dlpw' => $this->getTable('configdownloadable/link_price')),
                'dlpd.link_id = dlpw.link_id AND dlpw.website_id = i.website_id',
                array())
            ->where('dl.value = ?', 1)
            ->group(array('i.entity_id', 'i.customer_group_id', 'i.website_id'))
            ->columns(array(
                'min_price' => new Zend_Db_Expr('MIN('.$ifPrice.')'),
                'max_price' => new Zend_Db_Expr('SUM('.$ifPrice.')')
            ));

        $query = $select->insertFromSelect($table);
        $write->query($query);

        $ifTierPrice = $write->getCheckSql('i.tier_price IS NOT NULL', '(i.tier_price + id.min_price)', 'NULL');

        $select = $write->select()
            ->join(
                array('id' => $table),
                'i.entity_id = id.entity_id AND i.customer_group_id = id.customer_group_id'
                    .' AND i.website_id = id.website_id',
                array())
            ->columns(array(
                'min_price'  => new Zend_Db_Expr('i.min_price + id.min_price'),
                'max_price'  => new Zend_Db_Expr('i.max_price + id.max_price'),
                'tier_price' => new Zend_Db_Expr($ifTierPrice)
            ));

        $query = $select->crossUpdateFromSelect(array('i' => $this->_getDefaultFinalPriceTable()));
        $write->query($query);

        $write->delete($table);

        return $this;
    }
}
