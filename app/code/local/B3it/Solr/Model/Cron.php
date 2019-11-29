<?php

/**
 * @category    B3it
 * @package     B3it_Solr
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Cron extends Mage_Core_Model_Abstract
{
    /**
     * check solr-server connection
     */
    public function pingSolr()
    {
        /** @var Mage_Core_Model_Store $store */
        foreach (Mage::app()->getStores() as $store) {
            if (Mage::getStoreConfig('solr_security/solr_connection/check_connection', $store->getId())) {
                $server = new B3it_Solr_Model_Webservice_Solr();
                $server->storeId = $store->getId();
                $response = $server->testConnection();

                if ($response == null || $response->code != 200 || !isset($response->body->status) || $response->body->status != 'OK') {
                    Mage::Log('Solr Server Connection Test -- Header:' . $response->raw_headers . ' -- Body:' . $response->raw_body);
                    if (Mage::getStoreConfig('solr_security/solr_connection/send_email')) {
                        /** @var B3it_Solr_Helper_Data $helper */
                        $helper = Mage::helper('b3it_solr');
                        $helper->sendMailToAdmin($response->raw_body);
                    }
                }
            }
        }
    }

    /**
     * @throws Mage_Core_Exception
     * @throws Mage_Core_Model_Store_Exception
     */
    public function reindexProducts()
    {
        if (Mage::getStoreConfig('solr_general/index_options/enable_index_cron', Mage::app()->getStore()->getId())) {
            /** @var B3it_Solr_Model_Index_Product $model */
            $model = Mage::getModel('b3it_solr/index_product');

            if ($model != false) {
                /** @var Mage_Core_Model_Store $store */
                foreach (Mage::app()->getStores() as $store) {
                    $model->reIndexProducts($store->getId());
                }
            }
        }
    }
}
