<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_SearchController
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_SearchController extends Mage_Core_Controller_Front_Action
{
    /** @var B3it_Solr_Model_Search_Select */
    protected $_searchHandler;

    /**
     * @throws Mage_Core_Exception
     * @throws Mage_Core_Model_Store_Exception
     */
    public function indexAction()
    {
        $this->_searchHandler = Mage::getModel('b3it_solr/search_select');
        $query = $this->_searchHandler->getSecuredQuery($this->getRequest()->getParam('q'));
        Mage::getSingleton('customer/session')->setData('solr_q', $query);

        /** @var B3it_Solr_Model_Result $model */
        $model = Mage::getModel('b3it_solr/result');

        $this->_searchHandler->getQuery()
            ->setQuery($query)
            ->setFacetFields($this->_searchHandler->getFacets())
            ->setEdismaxFields($this->_searchHandler->getEdismaxFields())
            ->setEdismaxPhraseBoost($this->_searchHandler->getPhraseBoostedFields())
            ->setStart(0)
            ->setRows(Mage::getStoreConfig('solr_general/search_options/results_per_page_default', mage::app()->getStore()->getId()));

        try {
            // If No query is given (index bot, set empty result)
            if(mb_strlen($query) > 0){
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
        $this->renderLayout();
    }

    /**
     * returns json
     * @throws Mage_Core_Model_Store_Exception
     */
    public function suggestAction()
    {
        /** @var B3it_Solr_Model_Search_Suggest $model */
        $model = Mage::getModel('b3it_solr/search_suggest');
        $result = $model->query($model->getSecuredQuery($this->getRequest()->getParam('q')));

        die($result);
    }
}
