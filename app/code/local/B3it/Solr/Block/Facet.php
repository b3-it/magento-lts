<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Block_Facet
 * @author      Hana Anastasia matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Facet extends Mage_Core_Block_Template
{
    /**
     * @var B3it_Solr_Model_Result $_solrResult
     */
    protected $_solrResult = null;

    /**
     * @return array
     * @throws Mage_Core_Exception
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getFacetNames()
    {
        $model = $this->_getSolrResult();
        return $this->_getFacetLabel($model->getFacetList());
    }

    /**
     * @param array $facets
     * @return array
     * @throws Mage_Core_Exception
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function _getFacetLabel($facets)
    {
        /** @var Mage_Eav_Model_Entity_Attribute $model */
        $model = Mage::getModel('eav/entity_attribute');
        $labels = [];

        foreach (array_keys($facets) as $facet) {
            /** @var Mage_Eav_Model_Entity_Attribute $attribute */
            $attribute = $model->loadByCode('catalog_product', $facet);
            $labels[$facet] = $attribute->getStoreLabel(Mage::app()->getStore()->getId());
        }

        return $labels;
    }

    /**
     * @param string $key
     * @return array
     */
    public function getFacetValues($key)
    {
        $model = $this->_getSolrResult();
        return $this->_getFacetValue($model->getFacetList()[$key]);
    }

    /**
     * @param $key
     * @return array
     * @throws Mage_Core_Exception
     */
    public function getFacetPriceRange($key)
    {
        /** @var B3it_Solr_Helper_Data $helper */
        $helper = Mage::helper('b3it_solr');
        if ($helper->getDynamicField($key) != '_decimal') {
            // if field not decimal, break
            return [];
        } else {
            unset($helper);
        }

        try {
            $storeId = Mage::app()->getStore()->getId();
        } catch (Exception $e) {
            Mage::logException($e);
            $storeId = 0;
        }

        $resultSet = $this->_getSolrResult()->getFacetList()[$key];
        $resultValues = [];

        for ($i = 0; ; $i += 2) {
            if (empty($resultSet[$i])) {
                break;
            }
            $resultValues[] = $resultSet[$i];
            unset($resultSet[$i]);
        }

        // split result
        $resultValues = array_combine(range(1, count($resultValues)), array_values($resultValues));
        $resultSet = array_combine(range(1, count($resultSet)), array_values($resultSet));

        if (Mage::getStoreConfig('solr_general/price_range_options/custom_price_range_active', $storeId)) {
            return $this->_getCustomPriceRange($resultValues, $storeId);
        } else {
            return $this->_getDefaultPriceRange($resultValues, $resultSet, $storeId);
        }
    }

    /**
     * @param array $resultValues
     * @param array $resultSet
     * @param $storeId
     * @return array
     */
    protected function _getDefaultPriceRange(array $resultValues, array $resultSet, $storeId)
    {
        $count = Mage::getStoreConfig('solr_general/price_range_options/default_price_ranges', $storeId);
        if ($count < 1 || $count > 20) {
            // if default price range greater 20 or smaller 1, set it 5
            $count = 5;
        }

        $classes = [];
        $min = (float)min($resultValues);
        $max = (float)max($resultValues);
        $interval = round(($max - $min) / $count + 5, -1);

        for ($k = 0; $k < $count; $k++) {
            $minK = $k * $interval;
            $maxK = (1 + $k) * $interval;
            $countK = 0;
            foreach ($resultValues as $key => $price) {
                $price = (double)$price;
                if ($minK < $price && $price <= $maxK) {
                    $countK += 1 * $resultSet[$key];
                }
            }
            if (Mage::getStoreConfig('solr_general/price_range_options/price_range_empty_active', $storeId) || $countK > 0) {
                $classes[] = ['min' => $minK, 'max' => $maxK];
            }
        }
        return $classes;
    }

    /**
     * @param array $resultValues
     * @param $storeId
     * @return array
     */
    protected function _getCustomPriceRange(array $resultValues, $storeId)
    {
        // get Config for custom ranges, otherwise break
        $config = Mage::getStoreConfig('solr_general/price_range_options/custom_price_ranges', $storeId);
        if ($config) {
            $ranges = unserialize($config);
            unset($config);
        } else {
            return [];
        }

        $classes = [];
        if (Mage::getStoreConfig('solr_general/price_range_options/price_range_empty_active', $storeId)) {
            foreach ($ranges as $range) {
                $classes[] = ['min' => $range['price_min'], 'max' => $range['price_max']];
            }
        } else {
            foreach ($ranges as $range) {
                foreach ($resultValues as $value) {
                    if ($value <= $range['price_max'] && $value > $range['price_min']) {
                        $classes[] = ['min' => $range['price_min'], 'max' => $range['price_max']];
                        break;
                    }
                }
            }
        }
        return $classes;
    }

    /**
     * @param array $facet
     * @return array
     */
    protected function _getFacetValue($facet)
    {
        $values = [];
        $name = null;
        $count = null;

        foreach ($facet as $number => $value) {

            if ($number % 2 == 0) {
                $name = $value;
            } else {
                $count = $value;
            }

            if (!empty($name) && !empty($count)) {
                $value = [];
                $value['name'] = $name;
                $value['count'] = $count;
                $values[] = $value;
                $name = null;
                $count = null;
            }
        }
        return $values;
    }

    /**
     * @return B3it_Solr_Model_Result
     */
    protected function _getSolrResult()
    {
        if ($this->_solrResult == null) {
            $this->_solrResult = Mage::registry('solr_result');
        }
        return $this->_solrResult;
    }

    /**
     * @param $facetName
     * @return int
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getFacetBox($facetName)
    {
        /** @var B3it_Solr_Model_Search_Select $model */
        $model = Mage::getModel('b3it_solr/search_select');
        return $model->getFacetBox($facetName);
    }

    /**
     * @param $facetName
     * @return int
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getFacetExtended($facetName)
    {
        /** @var B3it_Solr_Model_Search_Select $model */
        $model = Mage::getModel('b3it_solr/search_select');
        return $model->getFacetExtended($facetName);
    }

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getSymbol()
    {
        return Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
    }
}
