<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Model_Index_Product
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Index_Product
{
    /** @var array */
    protected $searchData = array();

    /**
     * @param $observer
     * @throws Mage_Core_Model_Store_Exception
     */
    public function onProductSaveAfter($observer)
    {
        /** @var Mage_Catalog_Model_Product $product */
        $product = $observer->getProduct();
        /** @var Mage_Catalog_Model_Product_Visibility $visibilitySingleton */
        $visibilitySingleton = Mage::getSingleton('catalog/product_visibility');

        if (!$this->_getType($product)) {
            return;
        }

        if (!($product instanceof Mage_Catalog_Model_Product) || !$product->getId()) {
            return;
        }

        $this->searchData = $this->_getSearchableAttributes();

        /** @var Mage_Core_Model_Store $store */
        foreach (Mage::app()->getStores() as $store) {
            $storeId = $store->getId();
            $taxIncluded = $this->getTaxConfig($storeId);

            /** @var Mage_Catalog_Model_Product $product_store */
            $product_store = Mage::getModel('catalog/product')->setData('store_id', $storeId);
            $product_store->load($product->getId());

            if(!in_array($store->getWebsiteId(), $product_store->getWebsiteIds())){
                continue;
            }

            $client = new B3it_Solr_Model_Webservice_Solr();
            $client->storeId = $storeId;

            // if not visible/activated in search - Delete Solr Document and Return
            if (!in_array($product_store->getVisibility(), $visibilitySingleton->getVisibleInSearchIds()) || $product_store->getData('status') != Mage_Catalog_Model_Product_Status::STATUS_ENABLED) {
                $client->removeDocument('id:' . $this->_getId($product, $storeId));
                continue;
            }

            try {
                if ($client->addDocument($this->_getDocument($product_store, $storeId, $taxIncluded))) {
                    $this->singleProductMessage(true, $product, $store, ' added or updated. ');
                } else {
                    $this->singleProductMessage(false, $product, $store, ' could not be added or updated. ');
                }
            } catch (Exception $ex) {
                Mage::logException($ex);
                $this->singleProductMessage(false, $product, $store, ' could not be added or updated. ');
            }
        }
    }

    /**
     * @param $observer
     */
    public function onProductDeleteBefore($observer)
    {
        $product = $observer->getProduct();

        /** @var Mage_Core_Model_Store $store */
        foreach (Mage::app()->getStores() as $store) {
            $client = new B3it_Solr_Model_Webservice_Solr();
            $client->storeId = $store->getId();

            if ($client->removeDocument('id:' . $this->_getId($product, $store->getId()))) {
                $this->singleProductMessage(true, $product, $store, ' was removed. ');
            } else {
                $this->singleProductMessage(false, $product, $store, ' could not be removed. ');
            }
        }
    }

    /**
     * @param int $storeId
     * @throws Mage_Core_Exception
     * @throws Mage_Core_Model_Store_Exception
     */
    public function reIndexProducts($storeId = 0)
    {
        /** @var Mage_Catalog_Model_Resource_Product_Collection $collection */
        $collection = Mage::getModel('catalog/product')->getCollection();
        /** @var Mage_Core_Model_Store $store */
        $store = Mage::app()->getStore($storeId);

        $collection->addAttributeToSelect('*')
            ->addWebsiteFilter($store->getWebsiteId())
            ->setStoreId($storeId)
            ->addAttributeToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
            ->addAttributeToFilter([['attribute' => 'visibility', 'eq' => Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_SEARCH], ['attribute' => 'visibility', 'eq' => Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH]]);

        $client = new B3it_Solr_Model_Webservice_Solr();
        $client->storeId = $storeId;
        $client->removeDocument('type:product AND store_id:' . $storeId);

        $this->searchData = $this->_getSearchableAttributes();
        $taxIncluded = $this->getTaxConfig($storeId);
        $count = 0;
        $docs = null;

        // Admin Message
        $success = 0;
        $error = 0;
        $store = Mage::app()->getStore($storeId);

        foreach ($collection as $product) {

            if (!$this->_getType($product) || !($product instanceof Mage_Catalog_Model_Product) || !$product->getId()) {
                continue;
            }

            $docs .= $this->_getDocument($product, $storeId, $taxIncluded);
            $count++;
            if ($count >= 100) {
                try {
                    if ($client->addDocument($docs)) {
                        $success++;
                    } else {
                        $error++;
                    }
                    $count = 0;
                    $docs = null;
                } catch (Exception $ex) {
                    Mage::logException($ex);
                    $error++;
                }
            }
        }

        if ($docs != null) {
            try {
                if ($client->addDocument($docs)) {
                    $success++;
                } else {
                    $error++;
                }
            } catch (Exception $ex) {
                Mage::logException($ex);
                $error++;
            }
        }

        // Admin Message Output
        $this->multiProductMessage($success, $error, $store);
    }

    /**
     * @return Mage_Catalog_Model_Resource_Eav_Attribute[]
     */
    public function getSearchableAttributes()
    {
        return $this->_getSearchableAttributes();
    }

    /**
     * @param $storeId
     * @return bool
     */
    protected function getTaxConfig($storeId)
    {
        if (Mage::getStoreConfig('tax/display/type', $storeId) == Mage_Tax_Model_Config::DISPLAY_TYPE_INCLUDING_TAX) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @param $storeId
     * @param $taxIncluded
     * @return string
     * @throws Mage_Core_Exception
     */
    protected function _getDocument(Mage_Catalog_Model_Product $product, $storeId, $taxIncluded)
    {
        /** @var B3it_Solr_Model_Webservice_Input_Document $doc */
        $doc = new B3it_Solr_Model_Webservice_Input_Document();
        /** @var B3it_Solr_Helper_Data $solrHelper */
        $solrHelper = Mage::helper('b3it_solr');
        /** @var Mage_Tax_Helper_Data $taxHelper */
        $taxHelper = Mage::helper('tax');

        $doc->addField('type', 'product');
        $doc->addField('id', $this->_getId($product, $storeId));
        $doc->addField('db_id', $product->getId());
        $doc->addField('store_id', $storeId);
        $doc->addField('name', $this->secureValueForXml($product->getName()));

        // Module GroupsCatalog2 (hide product for group) - add hidden-group-id's to solr
        if (Mage::helper('core')->isModuleEnabled('Netzarbeiter_GroupsCatalog2')) {
            $groupsCatalog2_helper = Mage::helper('netzarbeiter_groupscatalog2');
            $group_ids = $product->getData($groupsCatalog2_helper::HIDE_GROUPS_ATTRIBUTE);
            $product_mode = Mage::getStoreConfig($groupsCatalog2_helper::XML_CONFIG_PRODUCT_MODE, $storeId);

            // Product Mode "show" -> multiselect "hide", None first priority, Other second priority and default last priority
            if ($product_mode === $groupsCatalog2_helper::MODE_SHOW_BY_DEFAULT) {
                if (in_array($groupsCatalog2_helper::USE_DEFAULT, $group_ids)) {
                    $default_options = Mage::getStoreConfig($groupsCatalog2_helper::XML_CONFIG_PRODUCT_DEFAULT_PREFIX . $groupsCatalog2_helper::MODE_HIDE_BY_DEFAULT, $storeId);
                    $group_ids = is_array($default_options) ? $default_options : [$default_options];
                }
                if (!in_array($groupsCatalog2_helper::USE_NONE, $group_ids)) {
                    foreach ($group_ids as $group_id) {
                        $doc->addField('hidden_group_ids', $group_id);
                    }
                }
            }
            // Product Mode "hide" -> multiselect "show", None first priority, Other second priority and default last priority
            //
            if ($product_mode === $groupsCatalog2_helper::MODE_HIDE_BY_DEFAULT) {
                $available_group_ids = $groupsCatalog2_helper->getCustomerGroupIds();
                if (in_array($groupsCatalog2_helper::USE_DEFAULT, $group_ids)) {
                    $default_options = Mage::getStoreConfig($groupsCatalog2_helper::XML_CONFIG_PRODUCT_DEFAULT_PREFIX . $groupsCatalog2_helper::MODE_SHOW_BY_DEFAULT, $storeId);
                    $group_ids = is_array($default_options) ? $default_options : [$default_options];
                }
                if (in_array($groupsCatalog2_helper::USE_NONE, $group_ids)) {
                    foreach ($available_group_ids as $group_id) {
                        $doc->addField('hidden_group_ids', $group_id);
                    }
                } else {
                    foreach ($available_group_ids as $group_id) {
                        if (!in_array($group_id, $group_ids)) {
                            $doc->addField('hidden_group_ids', $group_id);
                        }
                    }
                }
            }
        }

        foreach ($this->searchData as $search) {

            $attribute = $search->getData('attribute_code');
            $value = $product->getData($attribute);

            // Price Calculation
            // only if standard price is available OR at least a Price Config
            if ($attribute == 'price' && ($value != null || $product->hasProductConfig())) {

                // Default all other mods are disabled (Add all Modules to if - [DerModPro_BCP, ...])
                if (!Mage::helper('core')->isModuleEnabled('DerModPro_BCP')) {

                    // Catalog PriceRules calculation
                    /** @var Mage_CatalogRule_Model_Resource_Rule $catalogRule */
                    $catalogRule = Mage::getResourceModel('catalogrule/rule');
                    $price_with_rule = $catalogRule->getRulePrice(Mage::app()->getLocale()->storeTimeStamp($storeId), Mage::app()->getStore($storeId)->getWebsiteId(), 0, $product->getId());
                    if ($price_with_rule !== false) {
                        $product->setData($attribute, $price_with_rule);
                    }

                    // Tax calculation
                    if ($taxIncluded) {
                        $value = $taxHelper->getPrice($product, $product->getFinalPrice(), true, null, null, null, $storeId, null, true);
                    } else {
                        $value = $product->getFinalPrice();
                    }
                }

                // Module DerModPro_BCP is enabled (BCP)
                if (Mage::helper('core')->isModuleEnabled('DerModPro_BCP') && $product->getTypeId() == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE) {
                    /** @var Mage_Catalog_Model_Product $child */
                    if ($child = Mage::helper('bcp')->getCheapestChildProduct($product)) {
                        if ($child->getData($attribute) || $child->hasProductConfig()) {

                            // Catalog PriceRules calculation
                            /** @var Mage_CatalogRule_Model_Resource_Rule $catalogRule */
                            $catalogRule = Mage::getResourceModel('catalogrule/rule');
                            $price_with_rule = $catalogRule->getRulePrice(Mage::app()->getLocale()->storeTimeStamp($storeId), Mage::app()->getStore($storeId)->getWebsiteId(), 0, $child->getId());
                            if ($price_with_rule !== false) {
                                $child->setData($attribute, $price_with_rule);
                            }

                            // Add TaxClassId to child for Price calculation and add childId to solr for reference
                            $child->setData('tax_class_id', $child->getResource()->getAttributeRawValue($child->getId(), 'tax_class_id', $storeId));
                            $doc->addField('child_id_decimal', $child->getId());

                            //remove already calculated final price to calculate again
                            $child->unsetData('final_price');
                            $child->unsetData('my_final_price');

                            // Tax calculation - child
                            if ($taxIncluded) {
                                $value = $taxHelper->getPrice($child, $child->getFinalPrice(), true, null, null, null, $storeId, null, true);
                            } else {
                                $value = $child->getFinalPrice();
                            }
                        }
                    }
                }
            }

            if (!empty($value) && !empty($search['frontend_input'])) {

                if ($search['frontend_input'] == 'select') {
                    $options = Mage::getResourceModel('eav/entity_attribute_option_collection')->setAttributeFilter($search->getId())->setStoreFilter($storeId)->toOptionArray();
                    foreach ($options as $option) {
                        if ($option['value'] == $value) {
                            $value = $option['label'];
                            break;
                        }
                    }
                }
                if ($search['frontend_input'] == 'boolean') {
                    $value = ($value == '1') ? $solrHelper->__('Yes') : Mage::helper('b3it_solr')->__('No');
                }
                $doc->addField($attribute . $solrHelper->getDynamicField($search), $this->secureValueForXml($value));
            }
        }

        return $doc->toXml();
    }

    /**
     * @param mixed $value
     * @return mixed
     */
    protected function secureValueForXml($value)
    {
        if(is_string($value)){
            // escape special chars (decode first because of the & character)
            return htmlspecialchars(html_entity_decode($value));
        }
        return $value;
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @param int $storeId
     * @return string
     */
    protected function _getId($product, $storeId = 0)
    {
        return 'product_' . $product->getId() . '_' . $storeId;
    }

    /**
     * @return Mage_Catalog_Model_Resource_Eav_Attribute[]
     */
    protected function _getSearchableAttributes()
    {
        /** @var Mage_Eav_Model_Config $singleton */
        $singleton = Mage::getSingleton('eav/config');

        /** @var Mage_Catalog_Model_Resource_Product_Attribute_Collection $productAttributeCollection */
        $productAttributeCollection = Mage::getResourceModel('catalog/product_attribute_collection')
            ->setEntityTypeFilter($singleton->getEntityType(Mage_Catalog_Model_Product::ENTITY)->getEntityTypeId());
        $productAttributeCollection->addSearchableAttributeFilter();

        /** @var Mage_Catalog_Model_Resource_Eav_Attribute[] $attributes */
        $attributes = $productAttributeCollection->getItems();

        /* Remove Status and Visibility if not searchable */
        foreach ($attributes as $id => $attribute) {
            if ($attribute->getData('attribute_code') == 'visibility' || $attribute->getData('attribute_code') == 'status') {
                if ($attribute->getData('is_searchable') == 0) {
                    unset($attributes[$id]);
                }
            }
        }

        return $attributes;
    }

    /**
     * @param Mage_Catalog_Model_Product $product
     * @return bool
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function _getType(Mage_Catalog_Model_Product $product)
    {
        if (in_array($product->getData()['type_id'], explode(',', Mage::getStoreConfig('solr_general/index_options/solr_product_type', Mage::app()->getStore()->getId())))) {
            return false;
        }
        return true;
    }

    /**
     * @return array
     */
    public function getSearchData()
    {
        return $this->searchData;
    }

    /**
     * @param array $searchData
     */
    public function setSearchData($searchData)
    {
        $this->searchData = $searchData;
    }

    /**
     * @param bool $success
     * @param Mage_Catalog_Model_Product $product
     * @param Mage_Core_Model_Store $store
     * @param string $message
     */
    public function singleProductMessage($success, $product, $store, $message)
    {
        if (Mage::getStoreConfig('solr_security/solr_messages/afterSaveOrDelete_message')) {
            /** @var Mage_Core_Model_Session $singleton */
            $singleton = Mage::getSingleton('core/session');
            $message = $product->getName() . Mage::helper('b3it_solr')->__($message) . ' (' . Mage::getStoreConfig('solr_general/solr_connection/server_path', $store->getId()) . ' - ' . $store->getName() . ')';

            if ($success) {
                $singleton->addSuccess($message);
            } else {
                $singleton->addError($message);
            }
        }
    }

    /**
     * @param int $success
     * @param int $error
     * @param Mage_Core_Model_Store $store
     */
    public function multiProductMessage($success, $error, $store)
    {
        /** @var Mage_Core_Model_Session $singleton */
        $singleton = Mage::getSingleton('core/session');

        if ($error == 0) {
            $singleton->addSuccess('All Products indexed.' . ' (' . Mage::getStoreConfig('solr_general/solr_connection/server_path', $store->getId()) . ' - ' . $store->getName() .')');
        } else {
            $singleton->addError($error . ' of ' . ($error + $success) . ' requests could not be indexed.' . ' (' . Mage::getStoreConfig('solr_general/solr_connection/server_path', $store->getId()) . ' - ' . $store->getName() .')');
        }
    }
}
