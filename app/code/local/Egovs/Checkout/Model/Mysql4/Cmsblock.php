<?php
class Egovs_Checkout_Model_Mysql4_Cmsblock extends Mage_Core_Model_Mysql4_Abstract
{
	private $_StoreCategories = null;
	
	
    public function _construct()
    {    
        // Note that the extnewsletter_id refers to the key field in your database table.
        //$this->_init('mpcheckout/xx', 'extnewsletter_id');
         $helper = Mage::helper('catalog/category');
        $this->_StoreCategories = array();
        foreach($helper->getStoreCategories()->getNodes() as $node)
        {
        	$this->_StoreCategories[] = $node->getData('entity_id');
        }
    }
    
    public function loadAgreementTexts($productIds, $storeId)
    {
    	try
    	{
	    	$cattext = $this->_loadTextsFromCategory($productIds, true, $storeId);
	    	$prdtext = $this->_loadTextsFromProduct($productIds, true ,$storeId);
	    	return array_unique(array_merge($cattext,$prdtext));
    	}
    	catch(Exception $e)
		{
			Mage::log("mpcheckout(cmsblock)::".$e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
		
		return array();
    }
    
   public function loadInfoTexts($productIds, $storeId)
    {
    	try
    	{
	    	$cattext = $this->_loadTextsFromCategory($productIds, false, $storeId);
	    	$prdtext = $this->_loadTextsFromProduct($productIds, false ,$storeId);
	    	return array_unique(array_merge($cattext,$prdtext));
    	}
    	catch(Exception $e)
		{
			Mage::log("mpcheckout(cmsblock)::".$e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
		
		return array();
    }
    
    private function _loadTextsFromCategory($productIds, $isAgreement ,$storeId)
    {
    	$isAgreement = $isAgreement ? 1 : 0;
    	$res = array();
    	
    	//testen ob Attribut vorhanden
    	if(!$this->_testAttribute('catalog_category','infotext_block')) return $res;
    	
    	
    	foreach($productIds as $productId)
    	{
       	$collection = Mage::getResourceModel('catalog/category_collection')
            ->joinField('product_id',
                'catalog/category_product',
                'product_id',
                'category_id=entity_id',
                null)       
            ->addFieldToFilter('product_id', $productId)
            ->setStoreId($storeId)
            ->addIsActiveFilter()
            //->addAttributeToFilter('store_id',$storeId)
            ->addAttributeToSelect('infotext_block')
            ->addAttributeToFilter('infotext_block_checkbox',$isAgreement);
           
       //$collection->getSelect()->distinct('e.entity_id');
       //die($collection->getSelect()->__toString());
       $collection->load();

       foreach($collection->getItems() as $item)
       {
       		
       		$id = $item->getData('entity_id');
       		//$st = Mage::getSingleton('catalog/category')->getStoreIds($item);
       		if(in_array($id,$this->_StoreCategories))
       		{
       			$s = $item->getData('infotext_block');
       			if((isset($s)) && (strlen($s)>0))
       			{	
       				$s = trim($item->getData('infotext_block'));
       				if(strlen($s) > 0) $res[] = $s;
       			}
       		}
       }
    	} 
       return $res;   
    }
    
   private function _loadTextsFromProduct($productIds, $isAgreement ,$storeId)
    {
    	$isAgreement = $isAgreement ? 1 : 0;
    	$res = array();
    	//testen ob Attribut vorhanden
    	if(!$this->_testAttribute('catalog_product','infotext_block')) return $res;
    	foreach($productIds as $productId)
    	{
	       	$collection = Mage::getResourceModel('catalog/product_collection')
	            ->addFieldToFilter('entity_id', $productId)
	            ->addAttributeToSelect('infotext_block')
	            ->setStoreId($storeId)
	            ->addAttributeToFilter('infotext_block_checkbox',$isAgreement)
	            ->load();
	        
	       foreach($collection->getItems() as $item)
	       {
	       		//$st = $item->getStoreIds();
	       		//if(in_array($storeId,$st))
	       		{
	       			$s = $item->getData('infotext_block');
	       			if(isset($s))
	       			{	
	       				$s = trim($item->getData('infotext_block'));
	       				if(strlen($s) > 0) $res[] = $s;
	       			}
	       		}
	       } 
    	}
       return $res;   
    }
    
    private function _testAttribute($type = '',$att='')
    {
    	$eav = Mage::getResourceModel('eav/entity_attribute');
    	$id = $eav->getIdByCode($type,$att);
    	return $id !== false;
    }
    
}