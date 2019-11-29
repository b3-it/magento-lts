<?php

/**
 * @category    B3it
 * @package     B3it_Solr
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Index_Cms extends Mage_Core_Model_Abstract
{
    /**
     * @param $observer
     * @throws Mage_Core_Model_Store_Exception
     */
    public function onPageSaveAfter($observer)
    {
        if (!Mage::getStoreConfig('solr_general/index_options/search_cms', Mage::app()->getStore()->getId())) {
            return;
        }

        /** @var Mage_Cms_Model_Page $page */
        $page = $observer->getObject();
        $storeIds = [];

        /** @var Mage_Core_Model_Store $store */
        foreach (Mage::app()->getStores() as $store) {
            $storeIds[] = $store->getId();
        }

        if (!($page instanceof Mage_Cms_Model_Page) || !$page->getId()) {
            return;
        }

        if ($page->getStores()['0'] == 0 && count($page->getStores()) === 1) {
            $page_views = $storeIds;
        } else {
            $page_views = $page->getStores();
        }

        foreach ($storeIds as $storeId) {

            $client = new B3it_Solr_Model_Webservice_Solr();
            $client->storeId = $storeId;

            if ($page->getIsActive() != 1 || !in_array($storeId, $page_views)) {
                $client->removeDocument('id:' . 'cmsPage_' . $page->getId() . '_' . $storeId);
                continue;
            }

            try {
                $client->addDocument($this->_getDocument($page, $storeId));
            } catch (Exception $ex) {
                Mage::logException($ex);
            }
        }
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function onPageDeleteBefore($observer)
    {
        /** @var Mage_Cms_Model_Page $page */
        $page = $observer->getObject();

        /** @var Mage_Core_Model_Store $store */
        foreach (Mage::app()->getStores() as $store) {
            $client = new B3it_Solr_Model_Webservice_Solr();
            $client->storeId = $store->getId();
            $client->removeDocument('id:' . 'cmsPage_' . $page->getId() . '_' . $store->getId());
        }
    }

    /**
     * @param int $storeId
     */
    public function reIndexCMS($storeId = 0)
    {
        $collection = Mage::getModel('cms/page')->getCollection()
            ->addStoreFilter($storeId);

        $client = new B3it_Solr_Model_Webservice_Solr();
        $client->storeId = $storeId;
        $client->removeDocument('type:page AND store_id:' . $storeId);

        $count = 0;
        $docs = null;
        foreach ($collection as $page) {

            if (!($page instanceof Mage_Cms_Model_Page) || !$page->getId() || $page->getIsActive() != 1) {
                continue;
            }

            $docs .= $this->_getDocument($page, $storeId);
            $count++;

            if ($count >= 100) {
                try {
                    $client->addDocument($docs);
                    $count = 0;
                    $docs = null;
                } catch (Exception $ex) {
                    Mage::logException($ex);
                }
            }
        }

        if ($docs != null) {
            try {
                $client->addDocument($docs);
            } catch (Exception $ex) {
                Mage::logException($ex);
            }
        }
    }

    /**
     * @param Mage_Cms_Model_Page $page
     * @param $storeId
     * @return string
     */
    protected function _getDocument($page, $storeId)
    {
        $doc = new B3it_Solr_Model_Webservice_Input_Document();

        $doc->addField('type', 'page');
        $doc->addField('id', 'cmsPage_' . $page->getId() . '_' . $storeId);
        $doc->addField('db_id', $page->getId());
        $doc->addField('store_id', $storeId);
        $doc->addField('name', html_entity_decode(strip_tags($page->getTitle())));
        $doc->addField('content_text', html_entity_decode(strip_tags($page->getContent())));
        $doc->addField('title_string', html_entity_decode(strip_tags($page->getTitle())));

        return $doc->toXml();
    }
}
