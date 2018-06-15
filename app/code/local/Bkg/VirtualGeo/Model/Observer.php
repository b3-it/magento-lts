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

        $this->_saveComponentStorage($dataObject->getStorage(),$product,'virtualgeo/components_storageproduct');
    	$this->_saveComponent($dataObject->getGeoref(),$product,'virtualgeo/components_georefproduct');
    	$this->_saveComponent($dataObject->getFormat(),$product,'virtualgeo/components_formatproduct');
        $this->_saveComponent($dataObject->getStructure(), $product,'virtualgeo/components_structureproduct');
        $this->_saveComponent($dataObject->getResolution(),$product,'virtualgeo/components_resolutionproduct');
        $this->_saveComponent($dataObject->getAccounting(),$product,'virtualgeo/components_accountingproduct');
        $content = $dataObject->getContentLayerOptions();
        $this->_saveContentLayer($content,$product->getId());

    }
    

    protected function _saveContentLayer($nodes,$productId)
    {
        if($nodes == null)
        {
            return $this;
        }
        //deserialisierten wert ins array zurück schreiben
        foreach($nodes as $key =>$node)
        {
            $node = json_decode($node,true);
            $nodes[$key] = $node;
        }

    	//model erzeugen oder laden
    	foreach($nodes as $key =>$node)
        {
    		$model = Mage::getModel('virtualgeo/components_contentproduct')->load(intval($node['id']));
    		$model
                ->setPos($node['pos'])
                ->setEntityId($node['entity_id'])
                ->setProductId($productId) //FK
                ->setReadonly($node['is_readonly'])
                ->setIsChecked($node['is_checked'])
              //  ->setNodeId($node['node_id'])
            ;

    		$model->save();
            $nodes[$key]['id'] = $model->getId();
            $node['model'] = $model;
            $nodes[$key] = $node;
    	}
    
    	//jetzt die Elternbeziehung und die Reihenfolge
    	foreach($nodes as $node) {
    		$model = $node['model'];

            if (!isset($node['parent_number']) || empty($node['parent_number'])) {
                $model->unsetData('parent_node_id');
            } else {
                $parentNode = $this->__findByNumber($nodes, $node['parent_number']);
                $model->setParentNodeId($parentNode['model']->getNodeId());
            }

    		$model->save();
    
    	}
    
    	foreach($nodes as $node)
    	{
    		if($node['deleted'] == true){
    			$model = $node['model'];
    			$model->delete();
    		}
    	}
    
    
    
    }
    
    private function __findByNumber($nodes, $number)
    {
    	foreach ($nodes as $node){
    		if($node['number'] == $number){
    			return $node;
    		}
    	}
    
    	return null;
    }

    protected function _saveComponent($data, $product, $modelname)
    {
        if (empty($data)) {
            $data = array();
        }
       
            
        foreach($data as $key => $item){
        	if($key == 'is_default'){
        		continue;
        	}
        	$model = Mage::getModel($modelname);
        	if(isset($item['id']) && !empty($item['id'])){
        		$model->load($item['id']);
        		
        		if($item['deleted']  ){
        			$model->delete();
        			continue;
        		}
        	}
        	
        	
        	$model->setPos($item['position']);
        	$model->setEntityId($item['entity_id']);
        	$model->setProductId($product->getId());
        	$model->setStoreId($product->getStoreId());
        	$model->setIsDefault(0);
        	
        	if(isset($data['is_default']) && ($data['is_default'] == $item['my_id'])){
        		$model->setIsDefault(1);
        	}
        	$model->setData('is_visible_only_in_admin',0);
        	if(isset($item['admin_only'])){
        		$model->setData('is_visible_only_in_admin',1);
        	}
        	
        	$model->save();
        }
        
        $newItems = array();
    }
    
    protected function _saveComponentStorage($data, $product, $modelname)
    {
    	if (empty($data)) {
    		$data = array();
    	}
    	 
    
    	foreach($data as $key => $item){
    		if($key == 'is_default'){
    			continue;
    		}
    		$model = Mage::getModel($modelname);
    		if(isset($item['id']) && !empty($item['id'])){
    			$model->load($item['id']);
    
    			if($item['deleted']  ){
    				$model->delete();
    				continue;
    			}
    		}
    		 
    		 
    		$model->setPos($item['position']);
    		$model->setEntityId($item['entity_id']);
    		$model->setProductId($product->getId());
    		$model->setTransportProductId($item['transport_product_id']);
    		$model->setStoreId($product->getStoreId());
    		$model->setIsDefault(0);
    		 
    		if(isset($data['is_default']) && ($data['is_default'] == $item['my_id'])){
    			$model->setIsDefault(1);
    		}
    		$model->setData('is_visible_only_in_admin',0);
    		if(isset($item['admin_only'])){
    			$model->setData('is_visible_only_in_admin',1);
    		}
    		
    		$model->save();
    	}
    
    	$newItems = array();
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
   
    public function onHttpResponseSendBefore($observer)
    {
    	$response = $observer->getResponse();
    	$response->setHeader('Access-Control-Allow-Origin','*');
    }

    
}
