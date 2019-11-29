<?php

/**
 * @category    B3it
 * @package     B3it_Solr
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Result extends Mage_Catalog_Block_Product_List
{
    /** @var B3it_Solr_Model_Result */
    protected $_solrResult;

    /**
     * @return Mage_Catalog_Block_Product_Abstract
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @return array
     */
    public function getSuggestions()
    {
        return $this->_getSolrResult()->getSuggestion();
    }

    /**
     * @return B3it_Solr_Model_Result_Item[]
     */
    public function getList()
    {
        return $this->_getSolrResult()->getList();
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return preg_replace('/[\\\]/', '', $this->_getSolrResult()->getQuery());
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return (int)$this->_getSolrResult()->getCount();
    }

    /**
     * @return int
     */
    public function getStart()
    {
        return (int)$this->_getSolrResult()->getStart();
    }

    /**
     * @return int
     */
    public function getRows()
    {
        return (int)$this->_getSolrResult()->getRows();
    }

    /**
     * @return int
     */
    public function getPageCount()
    {
        if ($this->getRows() > 0) {
            return (int)ceil($this->getCount() / $this->getRows());
        }

        return 0;
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
     * @return array
     * @throws Mage_Core_Model_Store_Exception
     */
    public function getLimitValues()
    {
        return explode(',', Mage::getStoreConfig('solr_general/search_options/results_per_page', Mage::app()->getStore()->getId()));
    }

    /**
     * @return int
     */
    public function getLimitCurrent()
    {
        return $this->getRows();
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return ($this->_solrResult->getStart() / $this->_solrResult->getRows() + 1);
    }

    /**
     * @return int
     */
    public function getStartElement()
    {
        return $this->getStart() + 1;
    }

    /**
     * @return int
     */
    public function getLastElement()
    {
        $number = $this->getRows() + $this->getStart();
        if ($this->getCount() < $number) {
            return $this->getCount();
        }
        return $number;
    }
}
