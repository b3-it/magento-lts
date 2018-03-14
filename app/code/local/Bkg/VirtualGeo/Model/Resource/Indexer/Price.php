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
 * Bundle products Price indexer resource model
 *
 * @category    Mage
 * @package     Mage_Bundle
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Bkg_VirtualGeo_Model_Resource_Indexer_Price  extends Mage_Bundle_Model_Resource_Indexer_Price
{
    /**
     * Reindex temporary (price result data) for all products
     *
     * @return Mage_Bundle_Model_Resource_Indexer_Price
     */
    public function reindexAll()
    {
        $this->useIdxTable(true);

        $this->beginTransaction();
        try {
            $this->_prepareVirtualGeoPrice();
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
     * @param int|array $entityIds
     * @return Mage_Bundle_Model_Resource_Indexer_Price
     */
    public function reindexEntity($entityIds)
    {
        $this->_prepareVirtualGeoPrice($entityIds);

        return $this;
    }


    protected function _getPrice()
    {
    	return 13;
    }
    
    /**
     * Prepare temporary price index data for bundle products by price type
     *
     * @param int $priceType
     * @param int|array $entityIds the entity ids limitatation
     * @return Mage_Bundle_Model_Resource_Indexer_Price
     */
    protected function _prepareVirtualGeo($entityIds = null)
    {
        $write = $this->_getWriteAdapter();
        $table = $this->_getBundlePriceTable();

        $select = $write->select()
            ->from(array('e' => $this->getTable('catalog/product')), array('entity_id'))
            ->join(
                array('cg' => $this->getTable('customer/customer_group')),
                '',
                array('customer_group_id')
            );
        $this->_addWebsiteJoinToSelect($select, true);
        $this->_addProductWebsiteJoinToSelect($select, 'cw.website_id', 'e.entity_id');
        $select->columns('website_id', 'cw')
            ->join(
                array('cwd' => $this->_getWebsiteDateTable()),
                'cw.website_id = cwd.website_id',
                array()
            )
            ->joinLeft(
                array('tp' => $this->_getTierPriceIndexTable()),
                'tp.entity_id = e.entity_id AND tp.website_id = cw.website_id'
                    . ' AND tp.customer_group_id = cg.customer_group_id',
                array()
            )
            ->joinLeft(
                array('gp' => $this->_getGroupPriceIndexTable()),
                'gp.entity_id = e.entity_id AND gp.website_id = cw.website_id'
                    . ' AND gp.customer_group_id = cg.customer_group_id',
                array()
            )
            ->where('e.type_id=?', $this->getTypeId());

        // add enable products limitation
        $statusCond = $write->quoteInto('=?', Mage_Catalog_Model_Product_Status::STATUS_ENABLED);
        $this->_addAttributeToSelect($select, 'status', 'e.entity_id', 'cs.store_id', $statusCond, true);
        if (Mage::helper('core')->isModuleEnabled('Mage_Tax')) {
            $taxClassId = $this->_addAttributeToSelect($select, 'tax_class_id', 'e.entity_id', 'cs.store_id');
        } else {
            $taxClassId = new Zend_Db_Expr('0');
        }



        $price          = $this->_getPrice();// $this->_addAttributeToSelect($select, 'price', 'e.entity_id', 'cs.store_id');
        $specialPrice   = $this->_addAttributeToSelect($select, 'special_price', 'e.entity_id', 'cs.store_id');
        $specialFrom    = $this->_addAttributeToSelect($select, 'special_from_date', 'e.entity_id', 'cs.store_id');
        $specialTo      = $this->_addAttributeToSelect($select, 'special_to_date', 'e.entity_id', 'cs.store_id');
        $curentDate     = new Zend_Db_Expr('cwd.website_date');

        $specialExpr    = $write->getCheckSql(
            $write->getCheckSql(
                $specialFrom . ' IS NULL',
                '1',
                $write->getCheckSql(
                    $specialFrom . ' <= ' . $curentDate,
                    '1',
                    '0'
                )
            ) . " > 0 AND ".
            $write->getCheckSql(
                $specialTo . ' IS NULL',
                '1',
                $write->getCheckSql(
                    $specialTo . ' >= ' . $curentDate,
                    '1',
                    '0'
                )
            )
            . " > 0 AND {$specialPrice} > 0 AND {$specialPrice} < 100 ",
            $specialPrice,
            '0'
        );

        $groupPriceExpr = $write->getCheckSql(
            'gp.price IS NOT NULL AND gp.price > 0 AND gp.price < 100',
            'gp.price',
            '0'
        );

        $tierExpr       = new Zend_Db_Expr("tp.min_price");

       
            $finalPrice     = new Zend_Db_Expr($price);
            $tierPrice      = $write->getCheckSql($tierExpr . ' IS NOT NULL', '0', 'NULL');
            $groupPrice     = $write->getCheckSql($groupPriceExpr . ' > 0', $groupPriceExpr, 'NULL');
        

        $select->columns(array(
           // 'special_price'       => $specialExpr,
           // 'tier_percent'        => $tierExpr,
        	'tax_class_id'	=> new Zend_Db_Expr("0"),
            'orig_price'          => $write->getCheckSql($price . ' IS NULL', '0', $price),
           
            'price'               => $finalPrice,
            'min_price'           => $finalPrice,
            'max_price'           => $finalPrice,
            'tier_price'          => $tierPrice,
            //'base_tier'           => $tierPrice,
            'group_price'         => $groupPrice,
            //'base_group_price'    => $groupPrice,
            //'group_price_percent' => new Zend_Db_Expr('gp.price'),
        ));

        if (!is_null($entityIds)) {
            $select->where('e.entity_id IN(?)', $entityIds);
        }

        /**
         * Add additional external limitation
         */
        Mage::dispatchEvent('catalog_product_prepare_index_select', array(
            'select'        => $select,
            'entity_field'  => new Zend_Db_Expr('e.entity_id'),
            'website_field' => new Zend_Db_Expr('cw.website_id'),
            'store_field'   => new Zend_Db_Expr('cs.store_id')
        ));

        //die($select->__toString());
        $query = $select->insertFromSelect($this->getIdxTable());
       // die($query);
        $write->query($query);

        return $this;
    }

    /**
     * Calculate fixed bundle product selections price
     *
     * @return Mage_Bundle_Model_Resource_Indexer_Price
     */
    
    
    /**
     * Prepare temporary index price for bundle products
     *
     * @param int|array $entityIds  the entity ids limitation
     * @return Mage_Bundle_Model_Resource_Indexer_Price
     */
    protected function _prepareVirtualGeoPrice($entityIds = null)
    {
//         $this->_prepareTierPriceIndex($entityIds);
//         $this->_prepareGroupPriceIndex($entityIds);
//         $this->_prepareBundlePriceTable();
//         $this->_prepareBundlePriceByType(Mage_Bundle_Model_Product_Price::PRICE_TYPE_FIXED, $entityIds);
//         $this->_prepareBundlePriceByType(Mage_Bundle_Model_Product_Price::PRICE_TYPE_DYNAMIC, $entityIds);

        $this->_prepareVirtualGeo($entityIds);
        /**
         * Add possibility modify prices from external events
         */
        $select = $this->_getWriteAdapter()->select()
            ->join(array('wd' => $this->_getWebsiteDateTable()),
                'i.website_id = wd.website_id',
                array()
            );
        Mage::dispatchEvent('prepare_catalog_product_price_index_table', array(
            'index_table'       => array('i' => $this->_getBundlePriceTable()),
            'select'            => $select,
            'entity_id'         => 'i.entity_id',
            'customer_group_id' => 'i.customer_group_id',
            'website_id'        => 'i.website_id',
            'website_date'      => 'wd.website_date',
            'update_fields'     => array('price', 'min_price', 'max_price')
        ));

        $this->_movePriceDataToIndexTable();

        return $this;
    }

    /**
     * Prepare percentage tier price for bundle products
     *
     * @see Mage_Catalog_Model_Resource_Product_Indexer_Price::_prepareTierPriceIndex
     *
     * @param int|array $entityIds
     * @return Mage_Bundle_Model_Resource_Indexer_Price
     */
   

}
