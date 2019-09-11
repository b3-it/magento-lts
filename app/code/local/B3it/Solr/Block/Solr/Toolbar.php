<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Block_Solr_Toolbar
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Solr_Toolbar extends Mage_Core_Block_Template
{
    /**
     * @var B3it_Solr_Model_Result
     */
    protected $_solrResult = null;

    /**
     * @return Mage_Core_Block_Abstract
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
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
        } else {
            return 0;
        }
    }

    /**
     * @return array
     */
    public function getLimitValues()
    {
        try {
            return explode(',', Mage::getStoreConfig('solr_general/search_options/results_per_page', Mage::app()->getStore()->getId()));
        } catch (Exception $e) {
            Mage::logException($e);
        }
        return [];
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

    /**
     * @return array
     */
    public function getAvailableOrders()
    {
        $attributes = new B3it_Solr_Model_Index_Product();
        $options = [];
        $config = [];

        foreach ($attributes->getSearchableAttributes() as $attribute) {
            $options[Mage::helper('b3it_solr')->__($attribute->getData()['frontend_label'])] = $attribute->getData()['attribute_code'];
        }

        try {
            $config = explode(',', Mage::getStoreConfig('solr_general/sorting_options/sortable_attributes', Mage::app()->getStore()->getId()));
        } catch (Exception $e) {
            Mage::logException($e);
        }

        $orders = array_merge([Mage::helper('b3it_solr')->__('Relevance') => 'relevance'], array_intersect($options, $config));
        return $orders;
    }

    /**
     * @param $key
     * @return bool
     */
    public function isOrderCurrent($key)
    {
        if ($key == Mage::registry('solr_order_key')) {
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getCurrentDirection()
    {
        if ($direction = Mage::registry('solr_order_direction')) {
            return $direction;
        }
        return 'asc';
    }
}
