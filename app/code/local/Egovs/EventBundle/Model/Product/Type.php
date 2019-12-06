<?php
class Egovs_EventBundle_Model_Product_Type extends Mage_Bundle_Model_Product_Type
{

	const OPTION_VERIFIED = 2;
	/**
	 * Type ID
	 *
	 * Muss mit XML übereinstimmen!!
	 *
	 * @var string
	 */
	const TYPE_EVENTBUNDLE = 'eventbundle';

	private $_personalOptions = null;

	private $_isSaleAble = null;

	//überschrieben egal ob im Moment auf Lager
 	public function getSelectionsCollection($optionIds, $product = null)
    {
        $keyOptionIds = (is_array($optionIds) ? implode('_', $optionIds) : '');
        $key = $this->_keySelectionsCollection . $keyOptionIds;
        //if (!$this->getProduct($product)->hasData($key))
        {
            $storeId = $this->getProduct($product)->getStoreId();
            $selectionsCollection = Mage::getResourceModel('bundle/selection_collection')
                ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
                ->addAttributeToSelect('tax_class_id') //used for calculation item taxes in Bundle with Dynamic Price
                ->setFlag('require_stock_items', true)
                ->setFlag('product_children', true)
                ->setPositionOrder()
                ->addStoreFilter($this->getStoreFilter($product))
                ->setStoreId($storeId)
                ->addFilterByRequiredOptions()
                ->setOptionIdsFilter($optionIds);

            if (!Mage::helper('catalog')->isPriceGlobal() && $storeId) {
                $websiteId = Mage::app()->getStore($storeId)->getWebsiteId();
                $selectionsCollection->joinPrices($websiteId);
            }
			//$s = $selectionsCollection->getSelect()->__toString();
			foreach($selectionsCollection as $item)
			{
				if($item->getStatus() == Mage_Catalog_Model_Product_Status::STATUS_ENABLED){
					$item->setIsSalable(true);
				}
			}
            $this->getProduct($product)->setData($key, $selectionsCollection);
        }
        return $this->getProduct($product)->getData($key);
    }



    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode)
    {
    	$result = Mage_Catalog_Model_Product_Type_Abstract::_prepareProduct($buyRequest, $product, $processMode);

    	if (is_string($result)) {
    		return $result;
    	}

    	$selections = array();
    	$product = $this->getProduct($product);
    	$isStrictProcessMode = $this->_isStrictProcessMode($processMode);

    	$skipSaleableCheck = Mage::helper('catalog/product')->getSkipSaleableCheck();
    	$_appendAllSelections = (bool)$product->getSkipCheckRequiredOption() || $skipSaleableCheck;

    	$options = $buyRequest->getBundleOption();
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
    				if (($option->getRequired() == 1) && !isset($options[$option->getId()])) {
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

    		//produkte zum Vorbestellen
    		$requestedProducts = array();

    		// If product has not been configured yet then $selections array should be empty
    		if (!empty($selectionIds)) {
    			$selections = $this->getSelectionsByIds($selectionIds, $product);

    			// Check if added selections are still on sale
    			foreach ($selections->getItems() as $key => $selection) {
    				if (!$selection->isSalable() && !$skipSaleableCheck) {
    					$requestedProducts[] = $selection->getId();
    					$_option = $optionsCollection->getItemById($selection->getOptionId());
    					if (is_array($options[$_option->getId()]) && count($options[$_option->getId()]) > 1) {
    						$moreSelections = true;
    					} else {
    						$moreSelections = false;
    					}
    					if (($_option->getRequired() == 1)
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
            /* the inner empty array covers cases when no loops were made */
            $selections = [[]];
    		foreach ($options as $option) {
    			if (($option->getRequired() == 1) && (is_array($option->getSelections()) && count($option->getSelections()) == 1) ) {
    				$selections[] = $option->getSelections();
    			} else {
    				$selections = [[]];
    				break;
    			}
    		}
            if (version_compare(PHP_VERSION, '5.6', '>=')) {
                $selections = array_merge(...$selections);
            } else {
                /* PHP below 5.6 */
                $selections = call_user_func_array('array_merge', $selections);
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

    			$beforeQty = 0;
    			$customOption = $product->getCustomOption('product_qty_' . $selection->getId());
    			if ($customOption) {
    				$beforeQty = (float)$customOption->getValue();
    			}
    			$product->addCustomOption('product_qty_' . $selection->getId(), $qty + $beforeQty, $selection);

    			/*
    			 * Create extra attributes that will be converted to product options in order item
    			 * for selection (not for all bundle)
    			*/
    			//$price = $product->getPriceModel()->getSelectionPrice($product, $selection, $qty);
    			$price = $product->getPriceModel()->getSelectionFinalTotalPrice($product, $selection, 0, $qty);

    			$attributes = array(
    					'price'         => Mage::app()->getStore()->convertPrice($price),
    					'qty'           => $qty,
    					'option_label'  => $selection->getOption()->getTitle(),
    					'option_id'     => $selection->getOption()->getId()
    			);

    			$_result = $selection->getTypeInstance(true)->prepareForCart($buyRequest, $selection);
    			if (is_string($_result) && !is_array($_result)) {
    				return $_result;
    			}

    			if (!isset($_result[0])) {
    				return Mage::helper('checkout')->__('Cannot add item to the shopping cart.');
    			}

    			$result[] = $_result[0]->setParentProductId($product->getId())
    			->addCustomOption('bundle_option_ids', serialize(array_map('intval', $optionIds)))
    			->addCustomOption('bundle_selection_attributes', serialize($attributes));

    			if ($isStrictProcessMode) {
    				$_result[0]->setCartQty($qty);
    			}

    			$selectionIds[] = $_result[0]->getSelectionId();
    			$uniqueKey[] = $_result[0]->getSelectionId();
    			$uniqueKey[] = $qty;
    		}

    		// "unique" key for bundle selection and add it to selections and bundle for selections
    		$uniqueKey = implode('_', $uniqueKey);
    		foreach ($result as $item) {
    			$item->addCustomOption('bundle_identity', $uniqueKey);
    		}
    		$product->addCustomOption('bundle_option_ids', serialize(array_map('intval', $optionIds)));
    		$product->addCustomOption('bundle_selection_ids', serialize($selectionIds));

    		if(count($requestedProducts) > 0)
    		{
    			$product->addCustomOption('requested_products', serialize($requestedProducts));
    		}


    		$PersonalOptions = $buyRequest->getPersonalOptions();
    		if($PersonalOptions)
    		{
    			$product->addCustomOption('personal_options', serialize($PersonalOptions));
    		}


    		return $result;
    	}

    	return $this->getSpecifyOptionMessage();
    }

    /**
     * Check if product can be configured
     *
     * @param Mage_Catalog_Model_Product $product
     * @return bool
     */
    public function canConfigure($product = null)
    {
    	return $product instanceof Mage_Catalog_Model_Product
    	&& $product->isAvailable();
    }

    public function checkProductBuyState($product = null)
    {
    	Mage_Catalog_Model_Product_Type_Abstract::checkProductBuyState($product);
    	$product            = $this->getProduct($product);
    	$productOptionIds   = $this->getOptionsIds($product);
    	$productSelections  = $this->getSelectionsCollection($productOptionIds, $product);
    	$selectionIds       = $product->getCustomOption('bundle_selection_ids');
    	$selectionIds       = (array)unserialize($selectionIds->getValue());
    	$buyRequest         = $product->getCustomOption('info_buyRequest');
    	$buyRequest         = new Varien_Object(unserialize($buyRequest->getValue()));
    	$bundleOption       = $buyRequest->getBundleOption();

    	if (empty($bundleOption) && empty($selectionIds)) {
    		Mage::throwException($this->getSpecifyOptionMessage());
    	}

    	$skipSaleableCheck = Mage::helper('catalog/product')->getSkipSaleableCheck();
    	foreach ($selectionIds as $selectionId) {
    		/* @var $selection Mage_Bundle_Model_Selection */
    		$selection = $productSelections->getItemById($selectionId);
    		if (!$selection || (!$selection->isSalable() && !$skipSaleableCheck )) {
    			Mage::throwException(
    					Mage::helper('bundle')->__('Selected required options are not available.')
    			);
    		}
    	}

    	$product->getTypeInstance(true)->setStoreFilter($product->getStoreId(), $product);
    	$optionsCollection = $this->getOptionsCollection($product);

    	foreach ($optionsCollection->getItems() as $option) {
    		if (($option->getRequired() == 1)  && empty($selectionIds) && empty($bundleOption[$option->getId()])) {
    			Mage::throwException(
    					Mage::helper('bundle')->__('Required options are not selected.')
    			);
    		}
    	}

    	return $this;
    }


 	public function xxisSalable($product = null)
    {
    	if($this->_isSaleAble !== null)
    	{
    		return $this->_isSaleAble;
    	}
        $this->_isSaleAble = Mage_Catalog_Model_Product_Type_Abstract::isSalable($product);
        if (!$this->_isSaleAble) {
            return $this->_isSaleAble;
        }

        $optionCollection = $this->getOptionsCollection($product);

        if (!count($optionCollection->getItems())) {
            return false;
        }

        $requiredOptionIds = array();

        foreach ($optionCollection->getItems() as $option) {
            if ($option->getRequired()) {
                $requiredOptionIds[$option->getId()] = 0;
            }
        }

        $selectionCollection = $this->getSelectionsCollection($optionCollection->getAllIds(), $product);

        if (!count($selectionCollection->getItems())) {
            return false;
        }
        $salableSelectionCount = 0;
        foreach ($selectionCollection as $selection) {
            if ($selection->isSalable()) {
                $requiredOptionIds[$selection->getOptionId()] = 1;
                $salableSelectionCount++;
            }
			else {
				if($selection->getIsStockRule())
				{
					$this->_isSaleAble = false;
					return false;
				}
			}
        }

        $this->_isSaleAble = (array_sum($requiredOptionIds) == count($requiredOptionIds) && $salableSelectionCount);
        return $this->_isSaleAble;
    }


    public function getPersonalOptions()
    {
    	if($this->_personalOptions == null)
    	{
    		$collection = Mage::getModel('eventbundle/personal_option')->getCollection();
    		$collection->getSelect()
    		    ->where('product_id='. (int)$this->getProduct()->getId())
    		    ->order('pos');
    		$collection->setStoreId((int)$this->getProduct()->getStoreId());
    		$this->_personalOptions = $collection->getItems();
    	}

    	return $this->_personalOptions;
    }

    public function setPersonalOptions($options)
    {
    	$this->_personalOptions = $options;
    	return $this;
    }

    public function save($product = null)
    {
    	parent::save($product);
    	$product = $this->getProduct($product);
    	if($product)
    	{
	    	foreach($product->getPersonalOptions() as $option)
	    	{
	    		$option->setProductId($product->getId())
	    			->save();
	    	}
    	}
    	return $this;
    }

}
