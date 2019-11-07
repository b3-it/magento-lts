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
    protected $_list = [];

    /** @var array */
    protected $_facetList = [];

    /** @var string */
    protected $_query;

    /** @var int */
    protected $_count;

    /** @var int */
    protected $_start;

    /** @var int */
    protected $_rows;

    /** @var array */
    protected $_docs = [];

    /** @var array */
    protected $suggestion = [];

    /**
     *
     */
    public function load()
    {
        $this->_query = Mage::getSingleton('customer/session')->getData('solr_q');

        if (!is_null($header = $this->_getResponseHeader())) {
            $this->_start = $header->start ?? 0;
            $this->_rows = $header->rows ?? 0;
            unset($header);
        }

        if (!is_null($content = $this->_getResponseContent())) {
            $this->_count = $content->numFound ?? 0;
            $this->suggestion = $content->suggestion ?? [];
            $this->_docs = $content->docs ?? [];
            unset($content);
        }

        foreach ($this->_docs as $doc) {
            if (!empty($doc->db_id) && !empty($doc->type)) {
                /** @var B3it_Solr_Model_Result_Item $resultItem */
                $resultItem = Mage::getModel('b3it_solr/result_item');
                $resultItem->setId($doc->db_id);
                $resultItem->setType($doc->type);
                $this->_list[] = $resultItem;
            }
        }

        /* Facets */
        $facetsDefault = $this->_getFacetCount()->facet_fields ?? [];

        foreach ($facetsDefault as $key => $facet) {
            if (!empty($facet)) {
                $this->_facetList[preg_replace(array('/_decimal/', '/_text/', '/_string/', '/_date/', '/_facet/'), '', $key)] = $facet;
            }
        }
    }

    /**
     * @return stdclass | null
     */
    protected function _getFacetCount()
    {
        return $this->result->facet_counts ?? null;
    }

    /**
     * @return stdclass | null
     */
    protected function _getResponseHeader()
    {
        return $this->result->responseHeader->params ?? null;
    }

    /**
     * @return stdclass | null
     */
    protected function _getResponseContent()
    {
        return $this->result->response ?? null;
    }

    /**
     * @return stdclass | null
     */
    protected function _getSuggestionContent()
    {
        return $this->result->spellcheck->suggestions[1] ?? null;
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
