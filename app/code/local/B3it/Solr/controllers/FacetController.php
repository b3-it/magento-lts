<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_FacetController
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_FacetController extends Mage_Core_Controller_Front_Action
{
    /** @var B3it_Solr_Model_Search_Select */
    protected $_searchHandler = null;

    /** @var string */
    protected $_query = null;

    /**
     * @throws Mage_Core_Exception
     * @throws Mage_Core_Model_Store_Exception
     */
    public function facetAction()
    {
        $this->_searchHandler = Mage::getModel('b3it_solr/search_select');
        $this->_query = Mage::getSingleton('customer/session')->getData('solr_q');

        /** @var B3it_Solr_Model_Result $model */
        $model = Mage::getModel('b3it_solr/result');

        $this->_searchHandler->getQuery()
            ->setQuery($this->_query)
            ->setFacetFields($this->_searchHandler->getFacets())
            ->setEdismaxFields($this->_searchHandler->getEdismaxFields())
            ->setEdismaxPhraseBoost($this->_searchHandler->getPhraseBoostedFields())
            ->setFilter($this->_searchHandler->getFilters($this->getRequest()->getParam('f')));
        $this->_searchHandler->setPaging(0, Mage::getStoreConfig('solr_general/search_options/results_per_page_default', mage::app()->getStore()->getId()), $this->getRequest()->getParam('p'));

        try {
            // If No query is given (index bot, set empty result)
            if(mb_strlen($this->_query) > 0){
                $model->setResult($this->_searchHandler->sendQuery());
            } else {
                $model->setResult(new stdClass());
            }
            $model->load();
            Mage::register('solr_result', $model);
        } catch (Exception $e) {
            Mage::logException($e);
        }
        $this->loadLayout();
        $block = $this->getLayout()->getBlock('search_result_list');
        $this->getResponse()->setBody($block->toHtml());
    }
}
