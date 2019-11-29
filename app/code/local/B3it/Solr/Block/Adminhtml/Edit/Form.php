<?php

/**
 * @category    B3it
 * @package     B3it_Solr
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Adminhtml_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return array
     */
    public function getStoreViews()
    {
        $stores = [];
        $stores[] = ['value' => '0', 'label' => 'All'];
        /** @var Mage_Core_Model_Store $store */
        foreach (Mage::app()->getStores() as $store) {
            $stores[] = ['value' => $store->getId(), 'label' => $store->getName()];
        }
        return $stores;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        $types = [];
        /*if (Mage::getStoreConfig('solr_general/index_options/search_cms', Mage::app()->getStore()->getId())) {
            $types[] = ['value' => '0', 'label' => 'All'];
            $types[] = ['value' => '2', 'label' => 'Pages'];
        }*/
        $types[] = ['value' => '1', 'label' => 'Products'];
        return $types;
    }
}
