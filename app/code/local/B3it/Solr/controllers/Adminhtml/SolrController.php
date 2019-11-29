<?php

/**
 * @category    B3it
 * @package     B3it_Solr
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Adminhtml_SolrController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return $this
     */
    public function _initAction()
    {
        $this->loadLayout();
        $this->_setActiveMenu('system/solr_search');
        $this->_title($this->__('System'))->_title($this->__('Solr Search'));

        return $this;
    }

    /**
     * Show index and delete options for solr cores.
     */
    public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }

    /**
     * @throws Exception
     */
    public function reIndexAction()
    {
        /** @var Mage_Core_Model_Session $singleton */
        $singleton = Mage::getSingleton('core/session');
        $store = (int)$this->getRequest()->getParam('store', false);
        $type = (int)$this->getRequest()->getParam('type', false);
        $store = ($store < 0) ? 0 : $store;

        if ($type == 0) {
            $this->_reindexProduct($store);
            $this->_reIndexCms($store);
            $singleton->addSuccess(Mage::helper('b3it_solr')->__('Pages were added to Solr.'));
        } elseif ($type == 1) {
            $this->_reindexProduct($store);
        } elseif ($type == 2) {
            $this->_reIndexCms($store);
            $singleton->addSuccess(Mage::helper('b3it_solr')->__('Pages were added to Solr.'));
        } else {
            $singleton->addError(Mage::helper('b3it_solr')->__('Unknown type, please try again.'));
        }

        $this->getResponse()->setRedirect($this->getUrl('*/*/'));
    }

    /**
     * @throws Exception
     */
    public function clearAction()
    {
        /** @var Mage_Core_Model_Session $singleton */
        $singleton = Mage::getSingleton('core/session');
        $store = (int)$this->getRequest()->getParam('store', false);
        $type = (int)$this->getRequest()->getParam('type', false);
        $store = ($store < 0) ? 0 : $store;

        if ($type == 0) {
            $this->_clearProduct($store);
            $this->_clearCms($store);
            $singleton->addSuccess(Mage::helper('b3it_solr')->__('Products and Pages were removed from Solr.'));
        } elseif ($type == 1) {
            $this->_clearProduct($store);
            $singleton->addSuccess(Mage::helper('b3it_solr')->__('Products were removed from Solr.'));
        } elseif ($type == 2) {
            $this->_clearCms($store);
            $singleton->addSuccess(Mage::helper('b3it_solr')->__('Pages were removed from Solr.'));
        } else {
            $singleton->addError(Mage::helper('b3it_solr')->__('Unknown type, please try again.'));
        }

        $this->getResponse()->setRedirect($this->getUrl('*/*/'));
    }

    /**
     * @param $storeId
     * @throws Mage_Core_Exception
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function _reindexProduct($storeId)
    {
        /** @var B3it_Solr_Model_Index_Product $model */
        $model = Mage::getModel('b3it_solr/index_product');

        if ($model != false) {
            if ($storeId == 0) {
                /** @var Mage_Core_Model_Store $store */
                foreach (Mage::app()->getStores() as $store) {
                    $model->reIndexProducts($store->getId());
                }
            } else {
                $model->reIndexProducts($storeId);
            }
        }
    }

    /**
     * @param $storeId
     */
    protected function _reindexCms($storeId)
    {
        /** @var B3it_Solr_Model_Index_Cms $model */
        $model = Mage::getModel('b3it_solr/index_cms');

        if ($model != false) {
            if ($storeId == 0) {
                /** @var Mage_Core_Model_Store $store */
                foreach (Mage::app()->getStores() as $store) {
                    $model->reIndexCMS($store->getId());
                }
            } else {
                $model->reIndexCMS($storeId);
            }
        }
    }

    /**
     * @param int $storeId
     */
    protected function _clearProduct($storeId)
    {
        if ($storeId == 0) {
            /** @var Mage_Core_Model_Store $store */
            foreach (Mage::app()->getStores() as $store) {
                $client = new B3it_Solr_Model_Webservice_Solr();
                $client->storeId = $store->getId();
                $client->removeDocument('type:product');
                unset($client);
            }
        } else {
            $client = new B3it_Solr_Model_Webservice_Solr();
            $client->storeId = $storeId;
            $client->removeDocument('type:product');
        }
    }

    /**
     * @param int $storeId
     */
    protected function _clearCms($storeId)
    {
        if ($storeId == 0) {
            /** @var Mage_Core_Model_Store $store */
            foreach (Mage::app()->getStores() as $store) {
                $client = new B3it_Solr_Model_Webservice_Solr();
                $client->storeId = $store->getId();
                $client->removeDocument('type:page');
                unset($client);
            }
        } else {
            $client = new B3it_Solr_Model_Webservice_Solr();
            $client->storeId = $storeId;
            $client->removeDocument('type:page');
        }
    }
}
