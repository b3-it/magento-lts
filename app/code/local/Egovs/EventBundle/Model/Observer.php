<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Bundle
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Bundle Products Observer
 *
 * @category    Mage
 * @package     Mage_Bundle
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_EventBundle_Model_Observer
{
	private $_ProductIdSaveBefore = 0;
    /**
     * Setting Bundle Items Data to product for father processing
     *
     * @param Varien_Object $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function prepareProductSave($observer)
    {
        $request = $observer->getEvent()->getRequest();
        $product = $observer->getEvent()->getProduct();

        
        if($product->getTypeId() != Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE)
        {
        	return $this;
        }
        
        
        
        if (($items = $request->getPost('bundle_options')) && !$product->getCompositeReadonly()) {
            $product->setBundleOptionsData($items);
        }

        if (($selections = $request->getPost('bundle_selections')) && !$product->getCompositeReadonly()) {
            $product->setBundleSelectionsData($selections);
        }

        if($product->getTypeId() == Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE)
        {
	        if ($product->getPriceType() == '0' && !$product->getOptionsReadonly()) {
	            $product->setCanSaveCustomOptions(true);
	            if ($customOptions = $product->getProductOptions()) {
	                foreach (array_keys($customOptions) as $key) {
	                    //$customOptions[$key]['is_delete'] = 0;
	                    $customOptions[$key]['price'] = 0;
	                    $customOptions[$key]['price_type'] = 'fixed';
	                }
	                $product->setProductOptions($customOptions);
	            }
	        }
        }

        $product->setCanSaveBundleSelections(
            (bool)$request->getPost('affect_bundle_product_selections') && !$product->getCompositeReadonly()
        );

        $has_personal = false;
        $personalOptions = array();
        if ($personals = $request->getPost('personal_options')){
        	foreach($personals as $personal){
        		$has_personal = true;
        		$model = Mage::getModel('eventbundle/personal_option')->load(intval($personal['id']));
        		if($personal['is_delete']){
        			$model->delete();
        		}else{
	        		$model->setStoreId(intval($product->getStoreId()));
	        		$model->setName($personal['field']);
	        		$model->setPos(intval($personal['pos']));
	        		$model->setRequired(intval(isset($personal['required'])? 1:0));
	        		$model->setMaxLength(intval($personal['max']));
	        		$model->setLabel($personal['label']);
	        		$model->setProductId($product->getId());
	        		//$model->save();
	        		$personalOptions[] = $model;
        		}
        	}
        }
        
        $product->setPersonalOptions($personalOptions);
        
        if($has_personal && $product->getEventrequest()){
        	Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('eventbundle')->__('Using both "personal options" and "requires approval" is not recommended!'));
        }
        
        return $this;
    }

    /**
     * Append bundles in upsell list for current product
     *
     * @param Varien_Object $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function appendUpsellProducts($observer)
    {
        /* @var $product Mage_Catalog_Model_Product */
        $product = $observer->getEvent()->getProduct();

        /**
         * Check is current product type is allowed for bundle selection product type
         */
        if (!in_array($product->getTypeId(), Mage::helper('bundle')->getAllowedSelectionTypes())) {
            return $this;
        }

        /* @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Link_Product_Collection */
        $collection = $observer->getEvent()->getCollection();
        $limit      = $observer->getEvent()->getLimit();
        if (is_array($limit)) {
            if (isset($limit['upsell'])) {
                $limit = $limit['upsell'];
            } else {
                $limit = 0;
            }
        }

        /* @var $resource Mage_Bundle_Model_Mysql4_Selection */
        $resource   = Mage::getResourceSingleton('bundle/selection');

        $productIds = array_keys($collection->getItems());
        if (!is_null($limit) && $limit <= count($productIds)) {
            return $this;
        }

        // retrieve bundle product ids
        $bundleIds  = $resource->getParentIdsByChild($product->getId());
        // exclude up-sell product ids
        $bundleIds  = array_diff($bundleIds, $productIds);

        if (!$bundleIds) {
            return $this;
        }

        /* @var $bundleCollection Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
        $bundleCollection = $product->getCollection()
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addStoreFilter()
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents();

        Mage::getSingleton('catalog/product_visibility')
            ->addVisibleInCatalogFilterToCollection($bundleCollection);

        if (!is_null($limit)) {
            $bundleCollection->setPageSize($limit);
        }
        $bundleCollection->addFieldToFilter('entity_id', array('in' => $bundleIds))
            ->setFlag('do_not_use_category_id', true);

        if ($collection instanceof Varien_Data_Collection) {
            foreach ($bundleCollection as $item) {
                $collection->addItem($item);
            }
        } elseif ($collection instanceof Varien_Object) {
            $items = $collection->getItems();
            foreach ($bundleCollection as $item) {
                $items[$item->getEntityId()] = $item;
            }
            $collection->setItems($items);
        }

        return $this;
    }

    /**
     * Append selection attributes to selection's order item
     *
     * @param Varien_Object $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function appendBundleSelectionData($observer)
    {
        $orderItem = $observer->getEvent()->getOrderItem();
        $quoteItem = $observer->getEvent()->getItem();

        if ($attributes = $quoteItem->getProduct()->getCustomOption('bundle_selection_attributes')) {
            $productOptions = $orderItem->getProductOptions();
            $productOptions['bundle_selection_attributes'] = $attributes->getValue();
            $orderItem->setProductOptions($productOptions);
        }

        return $this;
    }

    /**
     * Add price index data for catalog product collection
     * only for front end
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function loadProductOptions($observer)
    {
        $collection = $observer->getEvent()->getCollection();
        /* @var $collection Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection */
        $collection->addPriceData();

        return $this;
    }

    /**
     * duplicating bundle options and selections
     *
     * @param Varien_Object $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function duplicateProduct($observer)
    {
        $product = $observer->getEvent()->getCurrentProduct();

        if ($product->getTypeId() != Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE) {
            //do nothing if not bundle
            return $this;
        }

        $newProduct = $observer->getEvent()->getNewProduct();

        $product->getTypeInstance(true)->setStoreFilter($product->getStoreId(), $product);
        $optionCollection = $product->getTypeInstance(true)->getOptionsCollection($product);
        $selectionCollection = $product->getTypeInstance(true)->getSelectionsCollection(
            $product->getTypeInstance(true)->getOptionsIds($product),
            $product
        );
        $optionCollection->appendSelections($selectionCollection);

        $optionRawData = array();
        $selectionRawData = array();

        $i = 0;
        foreach ($optionCollection as $option) {
            $optionRawData[$i] = array(
                    'required' => $option->getData('required'),
                    'position' => $option->getData('position'),
                    'type' => $option->getData('type'),
                    'title' => $option->getData('title')?$option->getData('title'):$option->getData('default_title'),
                    'delete' => ''
                );
            foreach ($option->getSelections() as $selection) {
                $selectionRawData[$i][] = array(
                    'product_id' => $selection->getProductId(),
                    'position' => $selection->getPosition(),
                    'is_default' => $selection->getIsDefault(),
                    'selection_price_type' => $selection->getSelectionPriceType(),
                    'selection_price_value' => $selection->getSelectionPriceValue(),
                    'selection_qty' => $selection->getSelectionQty(),
                    'selection_can_change_qty' => $selection->getSelectionCanChangeQty(),
                    'delete' => ''
                );
            }
            $i++;
        }

        $newProduct->setBundleOptionsData($optionRawData);
        $newProduct->setBundleSelectionsData($selectionRawData);
        
        $personalCollection = $product->getTypeInstance(false)->getPersonalOptions();
       	$personal = array();
       	
       	foreach($personalCollection as $option)
       	{
       		$labels = array();
       		foreach($option->getAllOptionLabels() as $label)
       		{
       			$label->unsId()->unsOptionId();
       			$labels[] = $label;
       			
       		}
       		$option->setAllOptionLabels($labels);	
       		$option->unsId()->unsProductId();
       		$personal[] = $option;
       	}
        
       	$newProduct->setPersonalOptions($personal);
        
        return $this;
    }

    /**
     * Setting attribute tab block for bundle
     *
     * @param Varien_Object $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function setAttributeTabBlock($observer)
    {
        $product = $observer->getEvent()->getProduct();
        if ($product->getTypeId() == Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE) {
            Mage::helper('adminhtml/catalog')
                ->setAttributeTabBlock('bundle/adminhtml_catalog_product_edit_tab_attributes');
        }
        return $this;
    }

    /**
     * Add price index to bundle product after load
     *
     * @deprecated since 1.4.0.0
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function catalogProductLoadAfter(Varien_Event_Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();
        if ($product->getTypeId() == Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE) {
            Mage::getSingleton('bundle/price_index')
                ->addPriceIndexToProduct($product);
        }

        return $this;
    }

    /**
     * CatalogIndex Indexer after plain reindex process
     *
     * @deprecated since 1.4.0.0
     * @see Mage_Bundle_Model_Mysql4_Indexer_Price
     *
     * @param Varien_Event_Observer $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function catalogIndexPlainReindexAfter(Varien_Event_Observer $observer)
    {
        $products = $observer->getEvent()->getProducts();
        Mage::getSingleton('bundle/price_index')->reindex($products);

        return $this;
    }
    
    
    
    
    /**
     * 
     * Speichern der ProduktStockAletert bei der Bestellung
     * @param Egovs_EventBundle_Model_Observer $observer
     */
    public function onSalesOrderSaveAfter($observer) {
    	/* @var $order Mage_Sales_Model_Order */
    	$order = $observer->getOrder();
   
    	if (!$order || $order->isEmpty()) {
    		return;
    	}
    
   
    	foreach($order->getAllItems() as $orderitem)
    	{
    		/* @var $orderitem Mage_Sales_Model_Order_Item */
    		if(count($orderitem->getChildrenItems()) > 0)
    		{
    			
    			if ($orderitem->getProductType() != Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE) {
    				return $this;
    			}	
    			
    			/* @var $quoteitem Mage_Sales_Model_Quote_Item */
    			$collection = Mage::getModel('sales/quote_item_option')->getCollection();
    			$collection->getSelect()
    				->where("code='requested_products'")
    				->where('item_id='.$orderitem->getQuoteItemId());
    			
    			foreach($collection->getItems() as $opt)
    			{
	    			$customOptions =  unserialize($opt->getValue());
	    			
	    			if($customOptions && is_array($customOptions))
	    			{
	    				foreach($customOptions as $p)
	    				{
	    					$alert = Mage::getModel('productalert/stock');
	    					$alert->setProductId($p);
	    					$alert->setCustomerId($order->getCustomerId());
	    					$alert->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
	    					$alert->setAddDate(now());
	    					$alert->save();
	    				}
	    			}
    			}
    			
    		}
    		
    	}
    
    }
    
    public function onProductSaveBefore($observer)
    {
    	$request = $observer->getEvent()->getRequest();
    	$product = $observer->getEvent()->getProduct();
    
    
    	if($product->getTypeId() != Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE)
    	{
    		return $this;
    	}
    	$this->_ProductIdSaveBefore = intval($product->getId());
    }
    
    public function onProductSaveAfter($observer)
    {
    	$request = $observer->getEvent()->getRequest();
    	$product = $observer->getEvent()->getProduct();
    
    
    	if($product->getTypeId() != Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE)
    	{
    		return $this;
    	}
    	
    	if(($this->_ProductIdSaveBefore != $product->getId()) && ($this->_ProductIdSaveBefore == 0))
    	{
    		Mage::dispatchEvent('eventbundle_create_after',  array('product' => $product));
    	}
    }
    	
    
}
