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
class Bkg_VirtualGeo_Model_Observer
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

        
        
        if($product->getTypeId() != Bkg_VirtualGeo_Model_Product_Type::TYPE_CODE)
        {
        	return $this;
        }
        
        $product->setPriceType(Mage_Bundle_Model_Product_Price::PRICE_TYPE_DYNAMIC);
        $productData =  $request->getPost('product');
        
       
        
        if (($items = $request->getPost('bundle_options')) && !$product->getCompositeReadonly()) {
            $product->setBundleOptionsData($items);
        }

        if (($selections = $request->getPost('bundle_selections')) && !$product->getCompositeReadonly()) {
            $product->setBundleSelectionsData($selections);
        }

        if($product->getTypeId() == Bkg_VirtualGeo_Model_Product_Type::TYPE_CODE)
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

        
        
        return $this;
    }


    /**
     * Setting Bundle Items Data to product for father processing
     *
     * @param Varien_Object $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function onProductSaveAfter($observer)
    {
    	$dataObject = $observer->getEvent()->getDataObject();
    	$product = $observer->getEvent()->getProduct();

    	if($product->getTypeId() != Bkg_VirtualGeo_Model_Product_Type::TYPE_CODE)
    	{
    		return $this;
    	}
    
    	if($dataObject->getRap()){
    		$this->_saveRap($dataObject->getRap(),$product);
    	}

    	$this->_saveGeoref($dataObject->getGeoref(), $dataObject->getGeorefDefault(),$product);
    	$this->_saveFormat($dataObject->getFormat(), $dataObject->getFormatDefault(),$product);
    }
    
    
    
    protected function _saveContentLayer($nodes,$productId)
    {
    	$loaded = array();
    	//model erzeugen oder laden
    	foreach($nodes as $node)
    	{
    		$model = Mage::getModel('virtualgeo/components_contentproduct');
    		if(!isset($node['id']) || empty($node['id']))
    		{
    			$model->save();
    			$node['id'] = $model->getId();
    			$node['model'] = $model;
    		}else {
    			$model = Mage::getModel('bkgviewer/composit_layer')->load($node['id']);
    			$node['model'] = $model;
    		}
    
    		$model->setTitle($node['title'])
    		->setPos($node['pos'])
    		->setVisualPos($node['visual_pos'])
    		->setType($node['type'])
    		->setCompositId($compositId);
    
    		if(!isset($node['serviceLayer']) || empty($node['serviceLayer']))
    		{
    			$model->unsetData('service_layer');
    		}else{
    
    			$model->setServiceLayerId($node['serviceLayer']);
    		}
    		$loaded[] = $node;
    
    	}
    
    	//jetzt die Elternbeziehung und die Reihenfolge
    	foreach($loaded as $node)
    	{
    
    		$model = $node['model'];
    		$parent = $this->findByNumber($loaded, $node['parent']);
    
    		if($parent){
    			$model->setParentId($parent['model']->getId());
    		}else{
    			$model->setData('parent_id',null);
    		}
    
    
    		$model->save();
    
    	}
    
    	foreach($loaded as $node)
    	{
    		if($node['is_delete']){
    			$model = $node['model'];
    			$model->delete();
    		}
    	}
    
    
    
    }
    
    private function findByNumber($nodes,$number)
    {
    	foreach ($nodes as $node){
    		if($node['number'] == $number){
    			return $node;
    		}
    	}
    
    	return null;
    }
    
    
    
    protected function _saveGeoref($data, $default, $product)
    {
    	if(empty($data)){
    		$data = array();
    	}
    	if(empty($default))
    	{
    		$default = array();
    	}
    	//evtl. vorhandene laden
    	$collection = Mage::getModel('virtualgeo/components_georefproduct')->getCollection();
    	$collection->getSelect()
    	->where('product_id = '.intval($product->getId()))
    	->where('store_id = '.intval($product->getStoreId()));
    	$newItems = array();
		
    	$defaultId = null;
    	//speichern
    	foreach($data as $id)
    	{
    		//ertmal die erste verwenden
    		if($defaultId === null)
    		{
    			$defaultId = $id;
    		}
    		if(in_array($id, $default)){
    			$defaultId = $id;
    		}
    		$found = false;
    		foreach($collection->getItems() as $item)
    		{
    			if($item->getGeorefId() == $id){
    				$found = true;
    				$newItems[] = $id;
    				break;
    			}
    		}
    		if(!$found)
    		{
    			$item = Mage::getModel('virtualgeo/components_georefproduct');
    			$item
    			->setProductId($product->getId())
    			->setStoreId($product->getStoreId())
    			->setGeorefId($id)
    			->save();
    			$newItems[] = $id;
    		}
    	}
    	
    	foreach($collection->getItems() as $item)
    	{
    		if(!in_array($item->getGeorefId(), $newItems)){
    			$item->delete();
    		}
    	}
    	 
    	Mage::getModel('virtualgeo/components_georefproduct')->saveDefault($defaultId,intval($product->getId()), intval($product->getStoreId()));
    }
    
    protected function _saveFormat($data, $default, $product)
    {
    	if(empty($data)){
    		$data = array();
    	}
    	if(empty($default))
    	{
    		$default = array();
    	}
    	//evtl. vorhandene laden
    	$collection = Mage::getModel('virtualgeo/components_formatproduct')->getCollection();
    	$collection->getSelect()
    	->where('product_id = '.intval($product->getId()))
    	->where('store_id = '.intval($product->getStoreId()));
    	$newItems = array();
    
    	$defaultId = null;
    	
    	//speichern
    	foreach($data as $id)
    	{
    		//ertmal die erste als default verwenden
    		if($defaultId === null)
    		{
    			$defaultId = $id;
    		}
    		//
    		if(in_array($id, $default)){
    			$defaultId = $id;
    		}
    		$found = false;
    		foreach($collection->getItems() as $item)
    		{
    			if($item->getFormatId() == $id){
    				$found = true;
    				$newItems[] = $id;
    				break;
    			}
    		}
    		if(!$found)
    		{
    			$item = Mage::getModel('virtualgeo/components_formatproduct');
    			$item
    			->setProductId($product->getId())
    			->setStoreId($product->getStoreId())
    			->setFormatId($id)
    			->save();
    			$newItems[] = $id;
    		}
    	}
    	 
    	foreach($collection->getItems() as $item)
    	{
    		if(!in_array($item->getFormatId(), $newItems)){
    			$item->delete();
    		}
    	}
    	
    	Mage::getModel('virtualgeo/components_formatproduct')->saveDefault(intval($defaultId),intval($product->getId()), intval($product->getStoreId()));
    	 
    }
    
    protected function _saveRap($rapData, $parent = null)
    {
    	//evtl. vorhandene laden
    	$collection = Mage::getModel('virtualgeo/components_regionallocation')->getCollection();
    	$collection->getSelect()
    	->where('parent_id = '.intval($parent->getId()));
    	$newItems = array();
    	$helper = Mage::helper('virtualgeo/rap');
    	//speichern
    	foreach($rapData as $ident=>$rap)
    	{
    		foreach($rap as $usage => $id)
    		{
    			if(!empty($id)){
		    		$tmp = $helper->findRap($collection->getItems(),$id,$ident,$usage);	
		    		$tmp->setParentId($parent->getId());
		    		$tmp->save();
		    		$newItems[] = $tmp;
    			}
    		}
    	}
    	
    	//löschen
    	foreach($collection->getItems() as $rap)
    	{
    		$tmp = $helper->findRap($newItems,$rap->getRapId(),$rap->getFee(),$rap->getUsage(),false);
    		if($tmp == null){
    			$rap->delete();
    		}
    	}
    }
    
   
    
    /**
     * Append selection attributes to selection's order item
     *
     * @param Varien_Object $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function appendBundleSelectionData($observer)
    {
    	return;
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
     * Setting attribute tab block for bundle
     *
     * @param Varien_Object $observer
     * @return Mage_Bundle_Model_Observer
     */
    public function setAttributeTabBlock($observer)
    {
        $product = $observer->getEvent()->getProduct();
        if ($product->getTypeId() == Bkg_VirtualGeo_Model_Product_Type::TYPE_CODE) {
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
        if ($product->getTypeId() == Bkg_VirtualGeo_Model_Product_Type::TYPE_CODE) {
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
    
    
    public function onCartProductAddAfter($observer)
    {
    	return $this;
    	$product = $observer->getEvent()->getProduct();
    	$quoteItem = $observer->getEvent()->getQuoteItem();
    	
    	if ($product->getTypeId() != Bkg_VirtualGeo_Model_Product_Type::TYPE_CODE) {
    		return $this;
    	}
    	
    	foreach($this->_getRapRelationCollection($product) as $rap)
    	{
    	
    		$rapProduct = Mage::getModel('catalog/product')
    		->setStoreId(Mage::app()->getStore()->getId())
    		->load($rap->getRapId());
    	
    		$this->_addRapToQuote($rapProduct,$quoteItem);
    	
    	}
    	
    	
    }
    

    
    
    /**
     * Retrieve checkout session model
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckoutSession()
    {
    	return Mage::getSingleton('checkout/session');
    }
   

    
}
