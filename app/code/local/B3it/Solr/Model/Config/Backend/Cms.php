<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Model_Config_Backend_Cms
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Config_Backend_Cms extends Mage_Core_Model_Config_Data
{
    /**
     * @return Mage_Core_Model_Abstract|void
     */
    public function _afterSave()
    {
        if ($this->isValueChanged()) {
            if (!empty($this->getValue())) {
                /** @var B3it_Solr_Model_Index_Cms $model */
                $model = Mage::getModel('b3it_solr/index_cms');

                /** @var Mage_Core_Model_Store $store */
                foreach (Mage::app()->getStores() as $store) {
                    $model->reIndexCMS($store->getId());
                }
            } else {
                /** @var Mage_Core_Model_Store $store */
                foreach (Mage::app()->getStores() as $store) {
                    $client = new B3it_Solr_Model_Webservice_Solr();
                    $client->storeId = $store->getId();
                    $client->removeDocument('type:page');
                }
            }
        }
    }
}
