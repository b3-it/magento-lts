<?php
class Dwd_ProductOnDemand_Model_Product_Type_Ondemand extends Mage_Downloadable_Model_Product_Type
{
	/**
	 * Type ID
	 * 
	 * Muss mit XML übereinstimmen!!
	 * 
	 * @var string
	 */
    const TYPE_DOWNLOAD_ON_DEMAND = 'prondemand';
    
    
    private $_reloadedProduct = null;
    
    /**
     * Check is product available for sale
     *
     * @param Mage_Catalog_Model_Product $product Product
     * 
     * @return bool
     */
    public function isSalable($product = null) {
    	return Mage_Catalog_Model_Product_Type_Abstract::isSalable($product);
    }
    
    /**
     * Save Product downloadable information (links and samples)
     *
     * @param Mage_Catalog_Model_Product $product
     * 
     * @return Mage_Downloadable_Model_Product_Type
     */
    public function save($product = null)
    {
    	$product = $this->getProduct($product);
    	/* @var Mage_Catalog_Model_Product $product */
    	
    	parent::save($product);
    
    	$product = $this->getProduct($product);
    	$this->setProduct($product);
    	/* @var Mage_Catalog_Model_Product $product */
    
    	
    	return $this;
    }
    
    public function addLinkItem($linkItem) {
    	/* @var Mage_Catalog_Model_Product $product */
    	$product = $this->getProduct();    	
    	
    	unset($linkItem['is_delete']);
    	if (!isset($linkItem['link_id'])) {
    		unset($linkItem['link_id']);
    	}
    	
    	$model = 'configdownloadable/extendedlink';
    	if (isset($linkItem['model'])) {
    		$model = $linkItem['model'];
    		unset ($linkItem['model']);
    	}
    	
    	if (isset($linkItem['url'])) {
    		$url = $linkItem['url'];
    		unset ($linkItem['url']);
    	}
    			
    	$linkModel = Mage::getModel($model)
	    	->setData($linkItem)
	    	->setLinkType($linkItem['type'])
	    	->setProductId($product->getId())
	    	->setStoreId(0)
	    	->setWebsiteId($product->getStore()->getWebsiteId())
	    	->setProductWebsiteIds($product->getWebsiteIds())
    	;
    	if (null === $linkModel->getPrice()) {
    		$linkModel->setPrice(0);
    	}
    	if ($linkModel->getIsUnlimited()) {
    		$linkModel->setNumberOfDownloads(0);
    	}
    	
    	if ($linkModel->getLinkType() == Mage_Downloadable_Helper_Download::LINK_TYPE_URL) {
    		$linkModel->setLinkUrl($url);
//     		$linkModel->setValidTo($linkItem['valid_to']);
    	}
    	
    	$linkModel->save();
    	
    	return $linkModel->getId();
    }
    
    public function canConfigure($product = null) {
    	return true;
    	
    }
    
    public function hasRequiredOptions($product = null) { 
       	return false;
    }
    
    /**
     * Liefert Downloadable Links
     *
     * @param Mage_Catalog_Model_Product $product
     * 
     * @return array
     */
    public function getLinksForSale($product = null) {
    	$product = $this->getProduct($product);
    	/* @var Mage_Catalog_Model_Product $product */
    	if (is_null($product->getDownloadableLinks())) {
    		$stationId = $product->getCustomOption('station_id');
    		$periodeId = $product->getCustomOption('periode_id');
    		/* @var $periodeItem Dwd_Periode_Model_Periode */
    		if (!$periodeId) {
    			$periodeItem = Dwd_Periode_Model_Periode::getNewOneDayDuration($product->getStorageTime());
    		} else {
	    		$periodeItem = Mage::getModel('periode/periode')->load($periodeId->getValue());
	    		if ($periodeItem->isEmpty()) {
	    			$periodeItem = Dwd_Periode_Model_Periode::getNewOneDayDuration($product->getStorageTime());
	    		}
    		}
    		
    		$_linkCollection = Mage::getModel('configdownloadable/extendedlink')->getCollection()
	    		->addProductToFilter($product->getId())
	    		->addFieldToFilter('link_station_id', $stationId->getValue())
	    		->addFieldToFilter('valid_to', array('from'=>$periodeItem->getStartDate(), 'to' => $periodeItem->getEndDate()))
	    		->addTitleToResult($product->getStoreId())
	    		->addPriceToResult($product->getStore()->getWebsiteId()
	    	);
    		$linksCollectionById = array();
    		foreach ($_linkCollection as $link) {
    			/* @var Dwd_ConfigurableDownloadable_Model_Extendedlink $link */
    			$link->setProduct($product);
    			$linksCollectionById[$link->getId()] = $link;
    		}
    		$product->setDownloadableLinks($linksCollectionById);
    	}
    	return $product->getDownloadableLinks();
    }
    
    protected function _prepareProduct(Varien_Object $buyRequest, $product, $processMode) {
    	if (!$buyRequest->hasProductInfo()) {
	    	$url = $this->getProduct($product)->getPodBaseUrl();
	    	$availUrl = $this->getProduct($product)->getPodAvailibilityUrl();
	    	$podTypeId = $this->getProduct($product)->getPodTypeId();
	    	if (!$url || !$availUrl || !$podTypeId) {
	    		return Mage::helper('prondemand')->__('Product is misconfigured.');
	    	}
	    	
	    	Mage::getSingleton('customer/session')->setPodTargetUrl($url);
	    	Mage::getSingleton('customer/session')->setPodAvailibilityUrl($availUrl);
	    	Mage::getSingleton('customer/session')->setPodTypeId($podTypeId);
	    	
	    	$url = 'prondemand/ondemand/redirectToWeste';
	    	$this->getProduct($product)->setRequestPath($url);
	    	
	    	$result = 'redirect';
    	} else {
    		$this->getProduct($product)->setLinksPurchasedSeparately(true);
    	
    		//Erst ganz am Ende
    		$result = parent::_prepareProduct($buyRequest, $product, $processMode);
    	}

    	return $result;
    }
    
    protected function getReloadedProduct($product) {
    	if ($this->_reloadedProduct == null) {
    		$this->_reloadedProduct = Mage::getModel('catalog/product')->load($product->getId());
    	}
    	return $this->_reloadedProduct;
    }
}
