<?php

/**
 * @category    B3it
 * @package     B3it_Solr
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Solr_List extends Mage_Catalog_Block_Product_Abstract
{
    /** @var B3it_Solr_Model_Result */
    protected $_solrResult;

    const TYPE_PRODUCT = 'product';
    const TYPE_PAGE = 'page';

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
     * @return B3it_Solr_Model_Result
     */
    protected function _getSolrResult()
    {
        if ($this->_solrResult == null) {
            $this->_solrResult = Mage::registry('solr_result');
        }
        return $this->_solrResult;
    }
}
