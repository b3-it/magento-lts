<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Model_Result
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Result
{
    /** @var stdClass */
    protected $result;

    /** @var array */
    protected $_list = array();

    /** @var array */
    protected $_facetList = array();

    /** @var string */
    protected $_query = null;

    /** @var int */
    protected $_count = null;

    /** @var int */
    protected $_start = null;

    /** @var int */
    protected $_rows = null;

    /** @var array */
    protected $suggestion = array();

    /**
     *
     */
    public function load()
    {
        $this->_start = isset($this->_getResponseHeader()->start) ? $this->_getResponseHeader()->start : 0;
        $this->_rows = isset($this->_getResponseHeader()->rows) ? $this->_getResponseHeader()->rows : 0;
        $this->_query = Mage::getSingleton('customer/session')->getData('solr_q');
        $this->_count = isset($this->_getResponseContent()->numFound) ? $this->_getResponseContent()->numFound : 0;
        $this->suggestion = isset($this->_getSuggestionContent()->suggestion) ? $this->_getSuggestionContent()->suggestion : array();
        $docs = isset($this->_getResponseContent()->docs) ? $this->_getResponseContent()->docs : array();

        foreach ($docs as $key => $doc) {

            if (!empty($doc->db_id) && !empty($doc->type)) {
                /** @var B3it_Solr_Model_Result_Item $resultItem */
                $resultItem = Mage::getModel('b3it_solr/result_item');
                $resultItem->setId($doc->db_id);
                $resultItem->setType($doc->type);
                $this->_list[] = $resultItem;
            } else {
                continue;
            }
        }

        /* Facets */
        $facetsDefault = (!empty($this->_getFacetCount()->facet_fields)) ? $this->_getFacetCount()->facet_fields : array();

        foreach ($facetsDefault as $key => $facet) {
            if (empty($facet)) {
                continue;
            }
            $this->_facetList[preg_replace(array('/_decimal/', '/_text/', '/_string/', '/_date/', '/_facet/'), '', $key)] = $facet;
        }
    }

    /**
     * @return stdclass | null
     */
    protected function _getFacetCount()
    {
        return (!empty($this->result->facet_counts)) ? $this->result->facet_counts : null;
    }

    /**
     * @return stdclass | null
     */
    protected function _getResponseHeader()
    {
        return (!empty($this->result->responseHeader->params)) ? $this->result->responseHeader->params : null;
    }

    /**
     * @return stdclass | null
     */
    protected function _getResponseContent()
    {
        return (!empty($this->result->response)) ? $this->result->response : null;
    }

    /**
     * @return stdclass | null
     */
    protected function _getSuggestionContent()
    {
        return (!empty($this->result->spellcheck->suggestions[1])) ? $this->result->spellcheck->suggestions[1] : null;
    }

    /**
     * @return stdClass
     */
    public function getSolrResult()
    {
        return $this->result->response;
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
     * @return B3it_Solr_Model_Result_Item[]
     */
    public function getList()
    {
        return $this->_list;
    }

    /**
     * @param $list
     * @return $this
     */
    public function setList($list)
    {
        $this->_list = $list;
        return $this;
    }

    /**
     * @return array
     */
    public function getFacetList()
    {
        return $this->_facetList;
    }

    /**
     * @param $facetList
     * @return $this
     */
    public function setFacetList($facetList)
    {
        $this->_facetList = $facetList;
        return $this;
    }

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
        $this->_query = $query;
        return $this;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->_count;
    }

    /**
     * @param $count
     * @return $this
     */
    public function setCount($count)
    {
        $this->_count = $count;
        return $this;
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return $this->_start;
    }

    /**
     * @param $start
     * @return $this
     */
    public function setStart($start)
    {
        $this->_start = $start;
        return $this;
    }

    /**
     * @return int
     */
    public function getRows()
    {
        return $this->_rows;
    }

    /**
     * @param $rows
     * @return $this
     */
    public function setRows($rows)
    {
        $this->_rows = $rows;
        return $this;
    }

    /**
     * @return array
     */
    public function getSuggestion()
    {
        return $this->suggestion;
    }

    /**
     * @param $suggestion
     * @return $this
     */
    public function setSuggestion($suggestion)
    {
        $this->suggestion = $suggestion;
        return $this;
    }

}
