<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Model_Search_Select
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Search_Select
{
    /** @var stdClass */
    protected $result = stdClass::class;

    /** @var B3it_Solr_Model_Webservice_Output_Query */
    protected $query = null;

    /** @var array */
    protected $facetConfiguration = null;

    /**
     * B3it_Solr_Model_Search_Select constructor.
     * @throws Mage_Core_Model_Store_Exception
     */
    public function __construct()
    {
        $this->query = new B3it_Solr_Model_Webservice_Output_Query();
        $this->_getFacetConfiguration();
    }

    /**
     * @return array
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function _getFacetConfiguration()
    {
        if ($this->facetConfiguration == null) {
            /** @var B3it_Solr_Helper_Data $helper */
            $helper = Mage::helper('b3it_solr');
            if ($helper != false) {
                $this->facetConfiguration = $helper->getFacetConfiguration();
            }
        }
        return $this->facetConfiguration;
    }

    /**
     * @param $q
     * @return string|string[]|null
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getSecuredQuery($q)
    {
        $length = (int)Mage::getStoreConfig('solr_general/search_options/max_query_length', mage::app()->getStore()->getId());
        if (filter_var($length, FILTER_VALIDATE_INT, ['min_range' => 1])) {
            $q = mb_substr($q, 0, $length);
        }

        $q = strip_tags(html_entity_decode($q));
        $q = addcslashes($q, '+-!(){}[]^"~*?:\\/|&');
        return $q;
    }

    /**
     * @param $filter
     * @return string
     */
    public function getSecuredFilter($filter)
    {
        $filter = strip_tags(html_entity_decode($filter));
        $filter = addcslashes($filter, '+-!(){}[]^"~*?:\\/|&');
        return urlencode($filter);
    }

    /**
     * @return array
     * @throws Mage_Core_Exception
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getEdismaxFields()
    {
        /** @var B3it_Solr_Model_Index_Product $indexProduct */
        $indexProduct = Mage::getModel('b3it_solr/index_product');
        /** @var B3it_Solr_Helper_Data $solrHelper */
        $solrHelper = Mage::helper('b3it_solr');

        $fields = [];
        foreach ($indexProduct->getSearchableAttributes() as $attr) {
            $fields[$attr->getData('attribute_code')] = $attr->getData('attribute_code') . $solrHelper->getDynamicField($attr);
        }

        if (Mage::getStoreConfig('solr_general/index_options/search_cms', mage::app()->getStore()->getId())) {
            $fields[] = "title_string";
            $fields[] = "content_text";
        }
        return $fields;
    }

    /**
     * @return array
     * @throws Mage_Core_Exception
     */
    public function getPhraseBoostedFields()
    {
        /** @var B3it_Solr_Helper_Data $solrHelper */
        $solrHelper = Mage::helper('b3it_solr');

        $fields = [];
        foreach ($this->facetConfiguration as $field) {
            if (isset($field['attribute']) && isset($field['priority']) && $field['priority'] != "") {
                $fields[$field['attribute'] . $solrHelper->getDynamicField($field['attribute'])] = $field['priority'];
            }
        }
        return $fields;
    }

    /**
     * @return array
     * @throws Mage_Core_Exception
     */
    public function getFacets()
    {
        /** @var B3it_Solr_Helper_Data $solrHelper */
        $solrHelper = Mage::helper('b3it_solr');

        $facets = [];
        foreach ($this->facetConfiguration as $facet) {
            if (isset($facet['attribute']) && isset($facet['filter']) && $facet['filter'] != 2) {
                if ($solrHelper->getDynamicField($facet['attribute']) == '_string') {
                    $facets[] = $facet['attribute'] . $solrHelper->getDynamicField($facet['attribute']) . '_facet';
                } else {
                    $facets[] = $facet['attribute'] . $solrHelper->getDynamicField($facet['attribute']);
                }
            }
        }
        return $facets;
    }

    /**
     * @return SimpleXMLElement
     * @throws Mage_Core_Model_Store_Exception
     */
    public function sendQuery()
    {
        $client = new B3it_Solr_Model_Webservice_Solr();
        $client->storeId = Mage::app()->getStore()->getId();
        $this->result = $client->query($this->query);
        return $this->result;
    }

    /**
     * @param $start
     * @param $rows
     * @param $page
     */
    public function SetPaging($start, $rows, $page)
    {
        if (!is_null($page) && is_array($page)) {
            $rows = (array_key_exists('limiter', $page)) ? (int)$page['limiter'] : $rows;
            if (array_key_exists('pager', $page) && array_key_exists('current', $page)) {

                $clicked = (int)$page['pager'];
                $current = (int)$page['current'];

                if ($clicked == 0) {
                    $start = $current * $rows;
                } elseif ($clicked == -1) {
                    $start = $current * $rows - $rows * 2;
                } else {
                    $start = $clicked * $rows - $rows;
                }
            }

            if (array_key_exists('order', $page)) {
                $order = $this->getSecuredFilter($page['order']);
                $this->query->setOrder($order);
                try {
                    Mage::register('solr_order_key', urldecode($order));
                } catch (Exception $e) {
                    Mage::logException($e);
                }
            }

            if (array_key_exists('direction', $page) && ($page['direction'] == 'asc' || $page['direction'] == 'desc')) {
                $this->query->setOrderDirection($page['direction']);
                try {
                    Mage::register('solr_order_direction', urldecode($page['direction']));
                } catch (Exception $e) {
                    Mage::logException($e);
                }
            }
        }
        $this->query->setStart($start);
        $this->query->setRows($rows);
    }

    /**
     * @param $facets
     * @return array
     * @throws Mage_Core_Exception
     */
    public function getFilters($facets = null)
    {
        /** @var B3it_Solr_Helper_Data $solrHelper */
        $solrHelper = Mage::helper('b3it_solr');

        if (is_array($facets) && !empty($facets)) {
            $dynamic = [];
            foreach ($facets as $facet) {
                if ($solrHelper->getDynamicField($facet['field']) == '_string') {
                    $dynamic[] = array('field' => $facet['field'] . $solrHelper->getDynamicField($facet['field']) . '_facet', 'value' => $this->getSecuredFilter($facet['value']));
                } else {
                    $dynamic[] = array('field' => $facet['field'] . $solrHelper->getDynamicField($facet['field']), 'value' => $this->getSecuredFilter($facet['value']));
                }
            }
            return $dynamic;
        } else {
            return [];
        }
    }

    /**
     * @param $facetName
     * @return int
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getFacetBox($facetName)
    {
        if ($this->facetConfiguration == null) {
            $this->_getFacetConfiguration();
        }

        if (is_array($this->facetConfiguration)) {
            foreach ($this->facetConfiguration as $facet) {
                if (isset($facet['attribute']) && $facet['attribute'] == $facetName) {
                    return (!is_null($facet['filter'])) ? (int)$facet['filter'] : 2;
                }
            }
        }
        return 2;
    }

    /**
     * @param $facetName
     * @return int
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getFacetExtended($facetName)
    {
        if ($this->facetConfiguration == null) {
            $this->_getFacetConfiguration();
        }

        if (is_array($this->facetConfiguration)) {
            foreach ($this->facetConfiguration as $facet) {
                if (isset($facet['attribute']) && $facet['attribute'] == $facetName) {
                    return (!is_null($facet['extended'])) ? (int)$facet['extended'] : -1;
                }
            }
        }
        return -1;
    }

    /** =============== Getter and Setter =============== */

    /**
     * @return stdClass
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param $result
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return B3it_Solr_Model_Webservice_Output_Query
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return array
     */
    public function getFacetConfiguration()
    {
        return $this->facetConfiguration;
    }

    /**
     * @param $facetConfiguration
     * @return $this
     */
    public function setFacetConfiguration($facetConfiguration)
    {
        $this->facetConfiguration = $facetConfiguration;
        return $this;
    }
}
