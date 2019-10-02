<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Model_Webservice_Output_Query
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Webservice_Output_Query
{
    protected $_query = "";
    protected $_group_id = 0;

    protected $_start = 0;
    protected $_rows = 50;
    protected $_min_count = 1;
    protected $_order = null;
    protected $_orderDirection = null;

    protected $_edismax = true;
    protected $_edismax_fields = array();
    protected $_edismax_phrase_boost = array();

    protected $_fields = ['type', 'id', 'db_id'];
    protected $_facet_fields = array();
    protected $_filters = array();

    /**
     * @return string
     * @throws Mage_Core_Model_Store_Exception
     */
    public function toString()
    {
        $storeId = Mage::app()->getStore()->getId();

        // Search Query
        $res = "?q=" . $this->_query;

        if (($fuzzy = Mage::getStoreConfig('solr_general/search_options/fuzzy_distance', $storeId)) > 0) {
            $res .= '~' . $fuzzy;
        }

        if (Mage::getStoreConfig('solr_general/spellcheck_options/spellcheck_active', $storeId)) {
            $res .= '&spellcheck=true';
            if (($spellcheck_results = Mage::getStoreConfig('solr_general/spellcheck_options/spellcheck_results', $storeId)) > 0) {
                $res .= '&spellcheck.maxResultsForSuggest=' . $spellcheck_results;
            }
        }

        //paging
        $res .= "&start=" . $this->_start;
        $res .= "&rows=" . $this->_rows;

        // Json
        $res .= "&wt=json";

        // Filter hidden groups (first filter query, because negative)
        if (Mage::helper('core')->isModuleEnabled('Netzarbeiter_GroupsCatalog2')) {
            $this->setGroupId();
            $res .= "&fq=-hidden_group_ids:" . $this->getGroupId();
        }

        // Filter the current ShopView to prevent errors by wrong configuration
        $res .= "&fq=store_id:" . $storeId;

        // Faceting on / off
        if (!empty($this->_facet_fields || !empty($this->_facets_range_fields))) {
            $res .= "&facet=true";
            $res .= "&facet.mincount=" . $this->_min_count;
        }

        // Faceting
        if (!empty($this->_facet_fields)) {

            foreach ($this->_facet_fields as $facet) {
                $res .= "&facet.field=" . "{!ex=dt}" . $facet;
            }
        }

        // Filter
        if (!empty($this->_filters)) {
            $buffer = null;
            foreach ($this->_filters as $filter) {
                if (empty($filter['field']) || empty($filter['value']) || $filter['value'] == '%2A') {
                    continue;
                }
                if ($buffer == $filter['field']) {
                    $res = substr($res, 0, -1);
                    if (strpos($filter['field'], '_decimal') !== false) {
                        $res .= "+OR+" . $filter['value'] . ")";
                    } else {
                        $res .= "+OR+\"" . $filter['value'] . "\")";
                    }

                } else {
                    if (strpos($filter['field'], '_decimal') !== false) {
                        $res .= "&fq={!tag=dt}" . $filter['field'] . ":(" . $filter['value'] . ")";
                    } else {
                        $res .= "&fq={!tag=dt}" . $filter['field'] . ":(\"" . $filter['value'] . "\")";
                    }
                }
                $buffer = $filter['field'];
            }
        }

        // Result Fields
        if (count($this->_fields) > 0) {
            $res .= "&fl=" . implode(',', $this->_fields);
        }

        if ($this->_edismax == true) {
            $res .= "&defType=edismax";
        }

        // Edismax Fields
        if ($this->_edismax == true && !empty($this->_edismax_fields)) {
            $first = true;
            foreach ($this->_edismax_fields as $field) {
                if (array_key_exists($field, $this->_edismax_phrase_boost)) {
                    $field .= '^' . $this->_edismax_phrase_boost[$field];
                } else {
                    $field .= '^0.5';
                }
                if ($first) {
                    $res .= "&qf=" . $field;
                    $first = false;
                } else {
                    $res .= "+" . $field;
                }
            }

            $res .= '+spelling^10&bq=spelling:' . $this->_query;
        }

        //OrderDirection without Order
        if (($this->_order == null || $this->_order == 'relevance') && $this->_orderDirection == 'asc') {
            $res .= '&sort=score+desc';
        }
        if (($this->_order == null || $this->_order == 'relevance') && $this->_orderDirection == 'desc') {
            $res .= '&sort=score+asc';
        }

        // Order
        if ($this->_order != null && array_key_exists($this->_order, $this->_edismax_fields)) {
            if ($this->_orderDirection == null) {
                $this->_orderDirection = 'asc';
            }

            if (strpos(($string_type = $this->_edismax_fields[$this->_order]), '_string') !== false) {
                $res .= '&sort=' . $string_type . '_facet' . '+' . $this->_orderDirection;
            }
            $res .= '&sort=' . $this->_edismax_fields[$this->_order] . '+' . $this->_orderDirection;
        }

        return $res;
    }

    /** =============== Getter and Setter =============== */

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->_query;
    }

    /**
     * @param $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->_query = urlencode($query);
        return $this;
    }

    /**
     * @return int
     */
    public function getGroupId(): int
    {
        return $this->_group_id;
    }

    /**
     * @return $this
     */
    public function setGroupId()
    {
        /** @var Mage_Customer_Model_Session $session */
        $session = Mage::getSingleton('customer/session');

        if($session->isLoggedIn()){
            $this->_group_id = $session->getCustomerGroupId();
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->_fields;
    }

    /**
     * @param $fields
     * @return $this
     */
    public function setFields($fields)
    {
        $this->_fields = $fields;
        return $this;
    }

    /**
     * @param $order
     * @return $this
     */
    public function setOrder($order)
    {
        $this->_order = $order;
        return $this;
    }

    /**
     * @param $direction
     * @return $this
     */
    public function setOrderDirection($direction)
    {
        $this->_orderDirection = $direction;
        return $this;
    }

    /**
     * @param $facets
     * @return $this
     */
    public function setFacetFields($facets)
    {
        $this->_facet_fields = $facets;
        return $this;
    }

    /**
     * @param $filters
     * @return $this
     */
    public function setFilter($filters)
    {
        $this->_filters = $filters;
        return $this;
    }

    /**
     * @param $start
     * @return $this
     */
    public function setStart($start)
    {
        if ($start > 0) {
            $this->_start = $start;
        }
        return $this;
    }

    /**
     * @param $rows
     * @return $this
     */
    public function setRows($rows)
    {
        if ($rows > 0) {
            $this->_rows = $rows;
        }
        return $this;
    }

    /**
     * @param $count
     * @return $this
     */
    public function setMinCount($count)
    {
        $this->_min_count = $count;
        return $this;
    }

    /**
     * @param $edismax
     * @return $this
     */
    public function setEdismax($edismax)
    {
        $this->_edismax = $edismax;
        return $this;
    }

    /**
     * @param $fields
     * @return $this
     */
    public function setEdismaxFields($fields)
    {
        $this->_edismax_fields = $fields;
        return $this;
    }

    /**
     * @param $fields
     * @return $this
     */
    public function setEdismaxPhraseBoost($fields)
    {
        $this->_edismax_phrase_boost = $fields;
        return $this;
    }
}
