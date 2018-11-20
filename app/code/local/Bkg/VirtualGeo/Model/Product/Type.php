<?php

class Bkg_VirtualGeo_Model_Product_Type extends Mage_Bundle_Model_Product_Type
{
    /**
     * Type ID
     *
     * Muss mit XML übereinstimmen!!
     *
     * @var string
     */
    const TYPE_CODE = 'virtualgeo';

    protected $_RapRelationCollection = NULL;
    protected $_resultParent = NULL;

    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode) {
        $this->_resultParent = Mage_Catalog_Model_Product_Type_Abstract::_prepareProduct($buyRequest, $product, $processMode);

        if (is_string($this->_resultParent)) {
            return $this->_resultParent;
        }

        $_result = $this->_processTypesOfUse($buyRequest, $product, $processMode);
        if (is_string($_result)) {
            return $_result;
        }

        /*
        $_result = $this->_processCrs($buyRequest, $product, $processMode);
        if (is_string($_result)) {
            return $_result;
        }
        */

        $selections = array();
        $product = $this->getProduct($product);
        $isStrictProcessMode = $this->_isStrictProcessMode($processMode);

        $skipSaleableCheck = Mage::helper('catalog/product')->getSkipSaleableCheck();
        $_appendAllSelections = (bool)$product->getSkipCheckRequiredOption() || $skipSaleableCheck;

        /**
         * bundle_option
         * array (optionId => selectionId)
         */
        $options = $buyRequest->getBundleOption();
        //TODO: Geo-Optionen zu $options hizufügen!

        if (is_array($options)) {
            $options = array_filter($options, 'intval');
            $qtys = $buyRequest->getBundleOptionQty();
            foreach ($options as $_optionId => $_selections) {
                if (empty($_selections)) {
                    unset($options[$_optionId]);
                }
            }
            $optionIds = array_keys($options);

            if (empty($optionIds) && $isStrictProcessMode) {
                return Mage::helper('bundle')->__('Please select options for product.');
            }

            $product->getTypeInstance(true)->setStoreFilter($product->getStoreId(), $product);
            $optionsCollection = $this->getOptionsCollection($product);
            if (!$this->getProduct($product)->getSkipCheckRequiredOption() && $isStrictProcessMode) {
                foreach ($optionsCollection->getItems() as $option) {
                    if ($option->getRequired() && !isset($options[$option->getId()])) {
                        return Mage::helper('bundle')->__('Required options are not selected.');
                    }
                }
            }
            $selectionIds = array();

            foreach ($options as $optionId => $selectionId) {
                if (!is_array($selectionId)) {
                    if ($selectionId != '') {
                        $selectionIds[] = (int)$selectionId;
                    }
                } else {
                    foreach ($selectionId as $id) {
                        if ($id != '') {
                            $selectionIds[] = (int)$id;
                        }
                    }
                }
            }
            // If product has not been configured yet then $selections array should be empty
            if (!empty($selectionIds)) {
                $selections = $this->getSelectionsByIds($selectionIds, $product);
                //die($selections->getSelect()->assemble());
                // Check if added selections are still on sale
                foreach ($selections->getItems() as $key => $selection) {
                    if (!$selection->isSalable() && !$skipSaleableCheck) {
                        $_option = $optionsCollection->getItemById($selection->getOptionId());
                        if (is_array($options[$_option->getId()]) && count($options[$_option->getId()]) > 1) {
                            $moreSelections = true;
                        } else {
                            $moreSelections = false;
                        }
                        if ($_option->getRequired()
                            && (!$_option->isMultiSelection() || ($_option->isMultiSelection() && !$moreSelections))
                        ) {
                            return Mage::helper('bundle')->__('Selected required options are not available.');
                        }
                    }
                }

                $optionsCollection->appendSelections($selections, false, $_appendAllSelections);

                $selections = $selections->getItems();
            } else {
                $selections = array();
            }
        } else {
            $product->setOptionsValidationFail(true);
            $product->getTypeInstance(true)->setStoreFilter($product->getStoreId(), $product);

            $optionCollection = $product->getTypeInstance(true)->getOptionsCollection($product);

            $optionIds = $product->getTypeInstance(true)->getOptionsIds($product);
            $selectionIds = array();

            $selectionCollection = $product->getTypeInstance(true)
                ->getSelectionsCollection(
                    $optionIds,
                    $product
                );

            $options = $optionCollection->appendSelections($selectionCollection, false, $_appendAllSelections);

            foreach ($options as $option) {
                if ($option->getRequired() && count($option->getSelections()) == 1) {
                    $selections = array_merge($selections, $option->getSelections());
                } else {
                    $selections = array();
                    break;
                }
            }
        }

        if (count($selections) > 0 || !$isStrictProcessMode) {
            $uniqueKey = array($product->getId());
            $selectionIds = array();

            // Shuffle selection array by option position
            usort($selections, array($this, 'shakeSelections'));

            foreach ($selections as $selection) {
                if ($selection->getSelectionCanChangeQty() && isset($qtys[$selection->getOptionId()])) {
                    $qty = (float)$qtys[$selection->getOptionId()] > 0 ? $qtys[$selection->getOptionId()] : 1;
                } else {
                    $qty = (float)$selection->getSelectionQty() ? $selection->getSelectionQty() : 1;
                }
                $qty = (float)$qty;

                $product->addCustomOption('selection_qty_' . $selection->getSelectionId(), $qty, $selection);
                $selection->addCustomOption('selection_id', $selection->getSelectionId());
                $product->addCustomOption('product_qty_' . $selection->getId(), $qty, $selection);

                /*
                 * Create extra attributes that will be converted to product options in order item
                 * for selection (not for all bundle)
                 */
                $price = $product->getPriceModel()->getSelectionFinalTotalPrice($product, $selection, 0, $qty);
                $attributes = array(
                    'price'         => Mage::app()->getStore()->convertPrice($price),
                    'qty'           => $qty,
                    'option_label'  => $selection->getOption()->getTitle(),
                    'option_id'     => $selection->getOption()->getId()
                );

                $_bundleResult = $selection->getTypeInstance(true)->prepareForCart($buyRequest, $selection);
                if (is_string($_bundleResult) && !is_array($_bundleResult)) {
                    return $_bundleResult;
                }

                if (!isset($_bundleResult[0])) {
                    return Mage::helper('checkout')->__('Cannot add item to the shopping cart.');
                }

                $this->_resultParent[] = $_bundleResult[0]->setParentProductId($product->getId())
                    ->addCustomOption('bundle_option_ids', serialize(array_map('intval', $optionIds)))
                    ->addCustomOption('bundle_selection_attributes', serialize($attributes));

                if ($isStrictProcessMode) {
                    $_bundleResult[0]->setCartQty($qty);
                }

                $selectionIds[] = $_bundleResult[0]->getSelectionId();
                $uniqueKey[] = $_bundleResult[0]->getSelectionId();
                $uniqueKey[] = $qty;
            }

            // "unique" key for bundle selection and add it to selections and bundle for selections
            $uniqueKey = implode('_', $uniqueKey);
            foreach ($this->_resultParent as $item) {
                $item->addCustomOption('bundle_identity', $uniqueKey);
            }
            $product->addCustomOption('bundle_option_ids', serialize(array_map('intval', $optionIds)));
            $product->addCustomOption('bundle_selection_ids', serialize($selectionIds));

            return $this->_resultParent;
        }

        return $this->getSpecifyOptionMessage();
    }

    /**
     * Verarbeitet das übergebene Coordinate Reference System (CRS)
     *
     * @param \Varien_Object $buyRequest
     * @param                $product
     * @param                $processMode
     *
     * @return self|string
     */
    protected function _processCrs(Varien_Object $buyRequest, $product, $processMode) {
        $crs = $buyRequest->getData('virtualgeo-components-georef');

        if (empty($crs) || !is_array($crs)) {
            return Mage::helper('checkout')->__('CRS is missing!');
        }

        $crs = $crs[0];

        if (!isset($this->_resultParent[0])) {
            return Mage::helper('checkout')->__('Cannot add item to the shopping cart.');
        }

        $this->_resultParent[0]
            ->addCustomOption('virtualgeo_georef', intval($crs))
        ;

        return $this;
    }

    protected function _processTypesOfUse(Varien_Object $buyRequest, $product, $processMode) {
        $typesOfUse = array();
        $toll = $buyRequest->getData('virtualgeo-components-toll');

        if (isset($toll['int']['use'])) {
            $typesOfUse[] = 'int';
        }
        if (isset($toll['ext']['use'])) {
            $typesOfUse[] = 'ext';
        }

        //TODO :: Use dynamic price
        $price = 100;

        //alle verfügbaren Entgelte abholen
        $fees = $sect = Mage::getConfig()->getNode('virtualgeo/fees/sections')->asArray();
        foreach ($typesOfUse as $usage) {
            foreach ($fees as $fee) {
                $raprel = $this->_getRapRelation($product, $fee['ident'], $usage);
                $taxraprel = $this->_getRapRelation($product, $fee['ident'], $usage . '_tax');

                $rapId = $raprel ? $raprel->getRapId() : NULL;
                $rapIdTax = $taxraprel ? $taxraprel->getRapId() : NULL;

                $raps = Mage::helper('regionallocation')->getRapProducts($rapId, $rapIdTax, $price, $fee['ident'], $usage);


                foreach ($raps as $rap) {
                    $_result = $rap->getTypeInstance(true)->prepareForCart($buyRequest, $rap);
                    if (is_string($_result) && !is_array($_result)) {
                        return $_result;
                    }

                    if (!isset($_result[0])) {
                        return Mage::helper('checkout')->__('Cannot add item to the shopping cart.');
                    }


                    $this->_resultParent[] = $_result[0]->setParentProductId($product->getId())
                        ->addCustomOption('fee',$rap->getFee())
                        ->addCustomOption('usage',$rap->getUsage())
                        ->addCustomOption('kst_id',$rap->getKst()->getId())
                        ->addCustomOption('kst_portions', serialize($rap->getPortions()));;
                }
            }
        }

        return $this;
    }


    /**
     * Ein array aller Reginallocations für das Produkt
     *
     * @param Mage_Catalog_Model_Product $product
     *
     * @return array[]
     */
    protected function _getRapRelationCollection($product, $usage) {
        $expr = new Zend_Db_Expr("`usage` = '".$usage."' OR `usage` = '".$usage."_tax'");
        if ($this->_RapRelationCollection == NULL) {
            $collection = Mage::getModel('virtualgeo/components_regionallocation')->getCollection();
            $collection->getSelect()
                ->order('fee')
                ->where($expr)
                ->where('parent_id = '.intval($product->getId()));
            $this->_RapRelationCollection = array();
            foreach($collection->getItems() as $item){
                $this->_RapRelationCollection[$item->getFee()][$item->getUsage()] = $item;
            }

        }

        return $this->_RapRelationCollection;
    }


    public function isSalable($product = null)
    {
        $salable = parent::isSalable($product);
        if (!is_null($salable)) {
            return $salable;
        }

        $storageCollection = Mage::getModel('virtualgeo/components_storageproduct')->getComponents4Product($this->getProduct()->getId(),$this->getProduct()->getStoreId());



        if (!count($storageCollection->getItems())) {
            return false;
        }



        foreach ($storageCollection->getItems() as $storage) {
            $storageProduct = Mage::getModel('catalog/product')->load($storage->getTransportProductId());
            if($storageProduct->isSalable()){
                return true;
            }
        }

        return false;
    }



    protected function _getRapRelation($product, $fee, $usage)
    {
        $items = $this->_getRapRelationCollection($product, $usage);

        if(isset($items[$fee])){
            if(isset($items[$fee][$usage])){
                return $items[$fee][$usage];
            }
        }

        return NULL;
    }


    /**
     * Check if product can be configured
     *
     * @param Mage_Catalog_Model_Product $product
     *
     * @return bool
     */
    public function canConfigure($product = NULL) {
        return $product instanceof Mage_Catalog_Model_Product
            && $product->isAvailable();
    }


    /**
     * Before save type related data
     *
     * @param Mage_Catalog_Model_Product $product
     */
    public function beforeSave($product = NULL) {
        parent::beforeSave($product);
        $product->setPriceType(Mage_Bundle_Model_Product_Price::PRICE_TYPE_DYNAMIC);
        return $this;
    }


    /**
     * Retrieve shopping cart model object
     *
     * @return Mage_Checkout_Model_Cart
     */
    protected function _getCart() {
        return Mage::getSingleton('checkout/cart');
    }

    /**
     * Retrieve bundle option collection
     *
     * @param Mage_Catalog_Model_Product $product
     * @return Mage_Bundle_Model_Mysql4_Option_Collection
     */
    public function getOptionsCollection($product = null)
    {
        if (!$this->getProduct($product)->hasData($this->_keyOptionsCollection)) {
            $optionsCollection = Mage::getModel('virtualgeo/bundle_option')->getResourceCollection()
                ->setProductIdFilter($this->getProduct($product)->getId())
                ->setPositionOrder();

            $storeId = $this->getStoreFilter($product);
            if ($storeId instanceof Mage_Core_Model_Store) {
                $storeId = $storeId->getId();
            }

            //$optionsCollection->joinValues($storeId);
            $this->getProduct($product)->setData($this->_keyOptionsCollection, $optionsCollection);
        }
        return $this->getProduct($product)->getData($this->_keyOptionsCollection);
    }

    public function getSelectionsByIds($selectionIds, $product = null) {
        sort($selectionIds);

        $usedSelections     = $this->getProduct($product)->getData($this->_keyUsedSelections);
        $usedSelectionsIds  = $this->getProduct($product)->getData($this->_keyUsedSelectionsIds);

        if (!$usedSelections || serialize($usedSelectionsIds) != serialize($selectionIds)) {
            $storeId = $this->getProduct($product)->getStoreId();
            $usedSelections = Mage::getResourceModel('virtualgeo/bundle_selection_collection')
                ->addAttributeToSelect('*')
                ->setFlag('require_stock_items', false)
                ->setFlag('product_children', false)
                ->addStoreFilter($this->getStoreFilter($product))
                ->setStoreId($storeId)
                ->setPositionOrder()
                ->addFilterByRequiredOptions()
                ->setSelectionIdsFilter($selectionIds);

            if (!Mage::helper('catalog')->isPriceGlobal() && $storeId) {
                $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
                $usedSelections->joinPrices($websiteId);
            }
            $this->getProduct($product)->setData($this->_keyUsedSelections, $usedSelections);
            $this->getProduct($product)->setData($this->_keyUsedSelectionsIds, $selectionIds);
        }
        return $usedSelections;
    }

    /**
     * Retrive bundle selections collection based on used options
     *
     * @param array $optionIds
     * @param Mage_Catalog_Model_Product $product
     * @return Mage_Bundle_Model_Mysql4_Selection_Collection
     */
    public function getSelectionsCollection($optionIds, $product = null)
    {
        $keyOptionIds = (is_array($optionIds) ? implode('_', $optionIds) : '');
        $key = $this->_keySelectionsCollection . $keyOptionIds;
        if (!$this->getProduct($product)->hasData($key)) {
            $storeId = $this->getProduct($product)->getStoreId();
            $selectionsCollection = Mage::getResourceModel('virtualgeo/bundle_selection_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addAttributeToSelect('tax_class_id') //used for calculation item taxes in Bundle with Dynamic Price
                ->setFlag('require_stock_items', false)
                ->setFlag('product_children', false)
                ->setPositionOrder()
                ->addStoreFilter($this->getStoreFilter($product))
                ->setStoreId($storeId)
                ->addFilterByRequiredOptions()
                ->setOptionIdsFilter($optionIds);

            if (!Mage::helper('catalog')->isPriceGlobal() && $storeId) {
                $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
                $selectionsCollection->joinPrices($websiteId);
            }

            $this->getProduct($product)->setData($key, $selectionsCollection);
        }
        return $this->getProduct($product)->getData($key);
    }

    /**
     * Process custom defined options for product
     *
     * @param Varien_Object $buyRequest
     * @param Mage_Catalog_Model_Product $product
     * @param string $processMode
     * @return array
     */
    protected function _prepareOptions(Varien_Object $buyRequest, $product, $processMode)
    {
        $transport = new StdClass;
        $transport->options = array();

        foreach (Bkg_VirtualGeo_Model_Product_Option::createOptionInstances() as $_option) {
            /** @var Bkg_VirtualGeo_Model_Product_Option $_option */
            /** @var Mage_Catalog_Model_Product_Option_Type_Default $group */
            $group = $_option->groupFactory($_option->getType())
                ->setOption($_option)
                ->setProduct($this->getProduct($product))
                ->setRequest($buyRequest)
                ->setProcessMode($processMode)
                ->validateUserValue($buyRequest->getOptions());

            $preparedValue = $group->prepareForCart();
            if ($preparedValue !== null) {
                $transport->options[$_option->getId()] = $preparedValue;
            }
        }

        $eventName = sprintf('catalog_product_type_prepare_%s_options', $processMode);
        Mage::dispatchEvent($eventName, array(
            'transport'   => $transport,
            'buy_request' => $buyRequest,
            'product' => $product
        ));
        return $transport->options;
    }
}
